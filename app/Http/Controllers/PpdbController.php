<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ppdb;
use App\Models\FormSection;
use App\Models\FormRequirement;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    public function create()
    {
        $sections = FormSection::with(['fields' => function($q) {
            $q->where('is_active', true)->orderBy('order_weight');
        }])->where('is_active', true)->orderBy('order_weight')->get();
        
        $requirements = FormRequirement::orderBy('order_weight')->get();

        return view('pages.ppdb', compact('sections', 'requirements'));
    }

    public function store(Request $request)
    {
        // 1. Build validation rules dynamically
        $rules = [];
        
        $sections = FormSection::with(['fields' => function($q) {
            $q->where('is_active', true);
        }])->where('is_active', true)->get();

        $messages = [
            'required' => ':attribute wajib diisi.',
            'file' => ':attribute harus berupa file yang valid.',
            'mimes' => ':attribute harus berformat: :values.',
            'max' => 'Ukuran :attribute tidak boleh lebih dari 2 MB.',
            'numeric' => ':attribute harus berupa angka.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'string' => ':attribute tidak valid.'
        ];

        $customAttributes = [];

        foreach ($sections as $section) {
            foreach ($section->fields as $field) {
                $rule = [];
                if ($field->is_required) {
                    $rule[] = 'required';
                } else {
                    $rule[] = 'nullable';
                }

                // Add specific rules based on type
                if ($field->type === 'number') {
                    $rule[] = 'numeric';
                } elseif ($field->type === 'date') {
                    $rule[] = 'date';
                } elseif ($field->type === 'text' || $field->type === 'textarea') {
                    $rule[] = 'string';
                }
                
                $rules['fields.' . $field->name] = implode('|', $rule);
                $customAttributes['fields.' . $field->name] = $field->label;
            }
        }

        // Requirements validation
        $isEditing = $request->has('edit_nomor');

        $requirements = FormRequirement::all();
        foreach ($requirements as $req) {
            $reqName = 'req_' . $req->id;
            $customAttributes[$reqName] = $req->name;

            if ($req->is_required && !$isEditing) {
                $rules[$reqName] = 'required|file|mimes:pdf,jpg,jpeg,png|max:2048';
            } else {
                $rules[$reqName] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048';
            }
        }

        $request->validate($rules, $messages, $customAttributes);

        // 2. Process data
        $formData = $request->input('fields', []);
        
        $reqData = [];
        $existingPpdb = null;

        if ($isEditing) {
            $existingPpdb = Ppdb::where('nomor', $request->input('edit_nomor'))->first();
            if ($existingPpdb && is_array($existingPpdb->requirements_data)) {
                $reqData = $existingPpdb->requirements_data;
            }
        }

        foreach ($requirements as $req) {
            $reqName = 'req_' . $req->id;
            if ($request->hasFile($reqName)) {
                // Delete old file if exists
                if ($isEditing && isset($reqData[$req->id]['file'])) {
                    if (\Storage::disk('public')->exists($reqData[$req->id]['file'])) {
                        \Storage::disk('public')->delete($reqData[$req->id]['file']);
                    }
                }
                
                $path = $request->file($reqName)->store('ppdb/requirements', 'public');
                $reqData[$req->id] = [
                    'name' => $req->name,
                    'file' => $path
                ];
            }
        }

        if ($isEditing && $existingPpdb) {
            $existingPpdb->update([
                'form_data' => $formData,
                'requirements_data' => $reqData,
                'status' => 'menunggu',
                'pesan_status' => null
            ]);
            
            $nomor_pendaftaran = $existingPpdb->nomor;
        } else {
            // Generate Registration Number
            $year = date('Y');
            $count = Ppdb::whereYear('created_at', $year)->count() + 1;
            $nomor_pendaftaran = 'PPDB-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);

            Ppdb::create([
                'nomor' => $nomor_pendaftaran,
                'form_data' => $formData,
                'requirements_data' => $reqData
            ]);
        }

        return redirect('/ppdb')->with([
            'success' => true,
            'is_edit' => $isEditing,
            'nomor_pendaftaran' => $nomor_pendaftaran
        ]);
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string|max:50'
        ]);

        $ppdb = Ppdb::where('nomor', $request->nomor)->first();

        // Pass sections and requirements again just in case the view needs them for the form tab
        $sections = FormSection::with(['fields' => function($q) {
            $q->where('is_active', true)->orderBy('order_weight');
        }])->where('is_active', true)->orderBy('order_weight')->get();
        
        $requirements = FormRequirement::orderBy('order_weight')->get();

        if ($ppdb) {
            return view('pages.ppdb', compact('sections', 'requirements'))->with([
                'check_result' => true,
                'ppdb_status' => $ppdb->status,
                'ppdb_pesan' => $ppdb->pesan_status,
                'ppdb_nomor' => $ppdb->nomor,
                'ppdb_data' => $ppdb->form_data, // pass basic data to show name
            ]);
        } else {
            return back()->with('error_cek', 'Data dengan Nomor Pendaftaran tersebut tidak ditemukan.');
        }
    }
}
