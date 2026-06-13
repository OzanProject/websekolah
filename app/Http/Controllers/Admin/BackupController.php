<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    protected $backupPath;

    public function __construct()
    {
        $this->backupPath = storage_path('app/backups');
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    public function index()
    {
        $files = File::files($this->backupPath);
        $backups = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'sql') {
                $backups[] = [
                    'filename' => $file->getFilename(),
                    'size' => number_format($file->getSize() / 1048576, 2) . ' MB',
                    'date' => Carbon::createFromTimestamp($file->getMTime())->format('Y-m-d H:i:s'),
                    'path' => $file->getPathname()
                ];
            }
        }

        // Urutkan dari yang terbaru
        usort($backups, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return view('admin.backups.index', compact('backups'));
    }

    public function create()
    {
        try {
            $dbHost = config('database.connections.mysql.host', '127.0.0.1');
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');

            $filename = 'backup_' . $dbName . '_' . date('Y_m_d_His') . '.sql';
            $filePath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

            // PURE PHP BACKUP (BYPASS CPANEL EXEC RESTRICTION)
            $pdo = new \PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $tables = [];
            $query = $pdo->query('SHOW TABLES');
            while ($row = $query->fetch(\PDO::FETCH_NUM)) {
                $tables[] = $row[0];
            }

            $sql = "-- Database Backup for {$dbName}\n";
            $sql .= "-- Generated at: " . date('Y-m-d H:i:s') . "\n\n";
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $query = $pdo->query("SHOW CREATE TABLE `{$table}`");
                $row = $query->fetch(\PDO::FETCH_NUM);
                $sql .= "-- Structure for table `{$table}`\n";
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n";
                $sql .= $row[1] . ";\n\n";

                $sql .= "-- Data for table `{$table}`\n";
                $query = $pdo->query("SELECT * FROM `{$table}`");
                $rowCount = $query->rowCount();

                if ($rowCount > 0) {
                    $sql .= "INSERT INTO `{$table}` VALUES \n";
                    $rowsData = [];
                    while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
                        $values = [];
                        foreach ($row as $value) {
                            if (is_null($value)) {
                                $values[] = "NULL";
                            } else {
                                $values[] = $pdo->quote($value);
                            }
                        }
                        $rowsData[] = "(" . implode(", ", $values) . ")";
                    }
                    $sql .= implode(",\n", $rowsData) . ";\n\n";
                }
            }
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

            file_put_contents($filePath, $sql);

            return back()->with('success', 'Backup database berhasil dibuat secara otomatis lewat sistem PHP murni: ' . $filename);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membackup database: ' . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $filePath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        if (File::exists($filePath)) {
            return response()->download($filePath);
        }

        return back()->with('error', 'File backup tidak ditemukan.');
    }

    public function destroy($filename)
    {
        $filePath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

        if (File::exists($filePath)) {
            File::delete($filePath);
            return back()->with('success', 'File backup berhasil dihapus.');
        }

        return back()->with('error', 'File backup tidak ditemukan.');
    }

    public function restore(Request $request)
    {
        try {
            $filePath = '';

            // Jika restore dari upload
            if ($request->hasFile('backup_file')) {
                $request->validate([
                    'backup_file' => 'required|file|mimetypes:text/plain,application/sql|mimes:sql|max:102400', // max 100MB
                ]);
                $file = $request->file('backup_file');
                $filename = 'uploaded_restore_' . date('Y_m_d_His') . '.sql';
                $file->move($this->backupPath, $filename);
                $filePath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;
            } 
            // Jika restore dari file yang sudah ada
            else if ($request->filled('filename')) {
                $filePath = $this->backupPath . DIRECTORY_SEPARATOR . $request->filename;
                if (!File::exists($filePath)) {
                    return back()->with('error', 'File backup tidak ditemukan.');
                }
            } else {
                return back()->with('error', 'Silakan pilih file backup atau upload file baru.');
            }

            // PURE PHP RESTORE (BYPASS CPANEL EXEC RESTRICTION)
            \Illuminate\Support\Facades\DB::unprepared(file_get_contents($filePath));

            return back()->with('success', 'Database berhasil di-restore dengan sempurna lewat sistem PHP!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem saat restore: ' . $e->getMessage());
        }
    }
}
