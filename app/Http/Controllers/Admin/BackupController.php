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
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');

            $filename = 'backup_' . $dbName . '_' . date('Y_m_d_His') . '.sql';
            $filePath = $this->backupPath . DIRECTORY_SEPARATOR . $filename;

            // Sesuaikan syntax mysqldump
            $passwordStr = empty($dbPass) ? '' : "-p\"{$dbPass}\"";
            $command = "mysqldump -h {$dbHost} -P {$dbPort} -u {$dbUser} {$passwordStr} {$dbName} > \"{$filePath}\" 2>&1";

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                // Hapus file jika gagal dibuat secara sempurna
                if (File::exists($filePath)) File::delete($filePath);
                
                return back()->with('error', 'Gagal membuat backup database. Pesan sistem: ' . implode("\n", $output));
            }

            return back()->with('success', 'Backup database berhasil dibuat: ' . $filename);

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
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

            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');

            $passwordStr = empty($dbPass) ? '' : "-p\"{$dbPass}\"";
            $command = "mysql -h {$dbHost} -P {$dbPort} -u {$dbUser} {$passwordStr} {$dbName} < \"{$filePath}\" 2>&1";

            exec($command, $output, $returnVar);

            if ($returnVar !== 0) {
                return back()->with('error', 'Gagal merestore database. Pesan sistem: ' . implode("\n", $output));
            }

            return back()->with('success', 'Database berhasil di-restore dengan sempurna!');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem saat restore: ' . $e->getMessage());
        }
    }
}
