<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ppdb;
use App\Models\FormField;

class PpdbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ppdbs = Ppdb::latest()->get();
        // Get fields that are set to be featured in the main datatable
        $featuredFields = FormField::where('is_featured', true)
                            ->where('is_active', true)
                            ->orderBy('order_weight')
                            ->get();

        return view('admin.ppdb.index', compact('ppdbs', 'featuredFields'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ppdb = Ppdb::findOrFail($id);
        return view('admin.ppdb.show', compact('ppdb'));
    }

    /**
     * Update the status of the specified resource.
     */
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diterima,ditolak',
            'pesan_status' => 'nullable|string'
        ]);

        $ppdb = Ppdb::findOrFail($id);
        $ppdb->status = $request->status;
        $ppdb->pesan_status = $request->pesan_status;
        $ppdb->save();

        return back()->with('success', 'Status kelulusan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ppdb = Ppdb::findOrFail($id);
        
        // Delete uploaded files if any
        if (is_array($ppdb->requirements_data)) {
            foreach ($ppdb->requirements_data as $req) {
                if (isset($req['file']) && \Storage::disk('public')->exists($req['file'])) {
                    \Storage::disk('public')->delete($req['file']);
                }
            }
        }
        
        $ppdb->delete();

        return redirect()->route('admin.ppdb.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }
}
