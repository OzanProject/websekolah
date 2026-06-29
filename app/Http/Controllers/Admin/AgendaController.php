<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Http\Requests\Admin\StoreAgendaRequest;
use App\Http\Requests\Admin\UpdateAgendaRequest;
use Yajra\DataTables\Facades\DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AgendaImport;
use App\Exports\AgendaTemplateExport;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Agenda::select(['id', 'title', 'date', 'time', 'location']);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($row) {
                    return '<input type="checkbox" class="checkItem" value="' . $row->id . '">';
                })
                ->editColumn('date', function ($row) {
                    return $row->date ? \Carbon\Carbon::parse($row->date)->translatedFormat('d F Y') : '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.agendas.edit', $row->id);
                    $deleteUrl = route('admin.agendas.destroy', $row->id);
                    $csrf = csrf_token();
                    
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="' . $deleteUrl . '" method="POST" class="d-inline swal-delete-form" data-confirm-msg="Apakah Anda yakin ingin menghapus agenda ini?">
                            <input type="hidden" name="_token" value="' . $csrf . '">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    ';
                })
                ->rawColumns(['checkbox', 'action'])
                ->make(true);
        }

        return view('admin.agendas.index');
    }

    public function create()
    {
        return view('admin.agendas.create');
    }

    public function store(StoreAgendaRequest $request)
    {
        Agenda::create($request->validated());

        return redirect()->route('admin.agendas.index')->with('success', 'Agenda berhasil ditambahkan');
    }

    public function edit(Agenda $agenda)
    {
        return view('admin.agendas.edit', compact('agenda'));
    }

    public function update(UpdateAgendaRequest $request, Agenda $agenda)
    {
        $agenda->update($request->validated());

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
