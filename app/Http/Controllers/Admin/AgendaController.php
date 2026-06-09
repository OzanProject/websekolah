<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AgendaImport;
use App\Exports\AgendaTemplateExport;

class AgendaController extends Controller
{
    public function index()
    {
        $agendas = Agenda::orderBy('date', 'desc')->get();
        return view('admin.agendas.index', compact('agendas'));
    }

    public function create()
    {
        return view('admin.agendas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|array',
            'location.id' => 'required|string|max:255',
        ]);

        Agenda::create($request->all());

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil ditambahkan');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(Request $request, Agenda $agenda)
    {
        $request->validate([
            'title' => 'required|array',
            'title.id' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string|max:255',
            'location' => 'required|array',
            'location.id' => 'required|string|max:255',
        ]);

        $agenda->update($request->all());

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil diperbarui');
    }

    public function destroy(Agenda $agenda)
    {
        $agenda->delete();

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil dihapus');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:agendas,id',
        ]);

        Agenda::whereIn('id', $request->ids)->delete();

        return response()->json(['success' => true, 'message' => 'Agenda terpilih berhasil dihapus.']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new AgendaImport, $request->file('file'));
            return redirect()->route('admin.agendas.index')->with('success', 'Data agenda berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('admin.agendas.index')->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new AgendaTemplateExport, 'Template_Import_Agenda.xlsx');
    }
}
