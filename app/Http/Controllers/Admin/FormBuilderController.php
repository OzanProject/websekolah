<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormSection;
use App\Models\FormField;
use App\Models\FormRequirement;
use App\Models\SchoolProfile;
use Illuminate\Support\Str;

class FormBuilderController extends Controller
{
    // === SECTIONS ===

    public function storeSection(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $maxOrder = FormSection::max('order_weight') ?? 0;
        
        FormSection::create([
            'name' => $request->name,
            'order_weight' => $maxOrder + 1,
            'is_active' => true
        ]);

        return back()->with('success', 'Bagian baru berhasil ditambahkan.');
    }

    public function updateSection(Request $request, FormSection $section)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order_weight' => 'required|integer'
        ]);

        $section->update([
            'name' => $request->name,
            'order_weight' => $request->order_weight,
            'is_active' => $request->has('is_active')
        ]);

        return back()->with('success', 'Bagian berhasil diperbarui.');
    }

    public function destroySection(FormSection $section)
    {
        $section->delete();
        return back()->with('success', 'Bagian beserta isinya berhasil dihapus.');
    }

    public function duplicateSection(FormSection $section)
    {
        $newSection = $section->replicate();
        $newSection->name = $section->name . ' (Copy)';
        $maxOrder = FormSection::max('order_weight') ?? 0;
        $newSection->order_weight = $maxOrder + 1;
        $newSection->save();

        foreach ($section->fields as $field) {
            $newField = $field->replicate();
            $newField->form_section_id = $newSection->id;
            $newField->name = $field->name . '_' . Str::random(4);
            $newField->save();
        }

        return back()->with('success', 'Bagian berhasil diduplikat.');
    }

    // === FIELDS ===

    public function storeField(Request $request)
    {
        $request->validate([
            'form_section_id' => 'required|exists:form_sections,id',
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,select,textarea',
        ]);

        $maxOrder = FormField::where('form_section_id', $request->form_section_id)->max('order_weight') ?? 0;

        $options = null;
        if ($request->type === 'select' && !empty($request->options)) {
            $options = array_map('trim', explode(',', $request->options));
        }

        FormField::create([
            'form_section_id' => $request->form_section_id,
            'label' => $request->label,
            'name' => Str::slug($request->label, '_') . '_' . Str::random(4),
            'help_text' => $request->help_text,
            'type' => $request->type,
            'options' => $options,
            'is_required' => $request->has('is_required'),
            'is_featured' => $request->has('is_featured'),
            'is_active' => true,
            'order_weight' => $maxOrder + 1
        ]);

        return back()->with('success', 'Kolom baru berhasil ditambahkan.');
    }

    public function updateField(Request $request, FormField $field)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string|in:text,number,date,select,textarea',
            'order_weight' => 'required|integer',
        ]);

        $options = null;
        if ($request->type === 'select' && !empty($request->options)) {
            $options = array_map('trim', explode(',', $request->options));
        }

        $field->update([
            'label' => $request->label,
            'help_text' => $request->help_text,
            'type' => $request->type,
            'options' => $options,
            'order_weight' => $request->order_weight,
            'is_required' => $request->has('is_required'),
            'is_active' => $request->has('is_active'),
            'is_featured' => $request->has('is_featured'),
        ]);

        return back()->with('success', 'Kolom berhasil diperbarui.');
    }

    public function destroyField(FormField $field)
    {
        $field->delete();
        return back()->with('success', 'Kolom berhasil dihapus.');
    }

    // === REQUIREMENTS ===

    public function storeRequirement(Request $request)
    {
        $request->validate(['name' => 'required|string']);
        
        $names = explode(',', $request->name);
        $maxOrder = FormRequirement::max('order_weight') ?? 0;

        foreach ($names as $name) {
            $name = trim($name);
            if (!empty($name)) {
                $maxOrder++;
                FormRequirement::create([
                    'name' => $name,
                    'is_required' => $request->has('is_required'),
                    'order_weight' => $maxOrder
                ]);
            }
        }

        return back()->with('success', 'Syarat dokumen berhasil ditambahkan.');
    }

    public function updateRequirement(Request $request, FormRequirement $requirement)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order_weight' => 'required|integer'
        ]);

        $requirement->update([
            'name' => $request->name,
            'order_weight' => $request->order_weight,
            'is_required' => $request->has('is_required')
        ]);

        return back()->with('success', 'Syarat dokumen berhasil diperbarui.');
    }

    public function destroyRequirement(FormRequirement $requirement)
    {
        $requirement->delete();
        return back()->with('success', 'Syarat dokumen berhasil dihapus.');
    }

    // === EXCEL TBD ===
    public function import(Request $request)
    {
        return back()->with('error', 'Fitur import Excel akan segera hadir!');
    }

    public function template()
    {
        return back()->with('error', 'Template Excel belum tersedia.');
    }
}
