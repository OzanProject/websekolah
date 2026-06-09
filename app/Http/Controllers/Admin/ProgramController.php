<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProgramImport;
use App\Exports\ProgramTemplateExport;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::latest()->get();
        return view('admin.programs.index', compact('programs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.programs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'description' => 'required|array',
            'icon' => 'nullable|string|max:255',
        ]);

        Program::create($request->all());

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        return view('admin.programs.edit', compact('program'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Program $program)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'description' => 'required|array',
            'icon' => 'nullable|string|max:255',
        ]);

        $program->update($request->all());

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:programs,id',
        ]);

        Program::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Program terpilih berhasil dihapus.']);
    }

    /**
     * Import programs from Excel.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new ProgramImport, $request->file('file'));
            return redirect()->route('admin.programs.index')->with('success', 'Data program berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('admin.programs.index')->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
        }
    }

    /**
     * Download Excel template for import.
     */
    public function downloadTemplate()
    {
        return Excel::download(new ProgramTemplateExport, 'Template_Import_Program.xlsx');
    }
}
