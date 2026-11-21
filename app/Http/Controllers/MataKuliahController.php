<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliahs = MataKuliah::orderBy('semester')->orderBy('kode_mk')->get();
        return view('mata_kuliah.index', compact('mataKuliahs'));
    }

    public function create()
    {
        return view('mata_kuliah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliahs,kode_mk',
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        MataKuliah::create($validated);

        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Data mata kuliah berhasil ditambahkan.');
    }

    public function edit(MataKuliah $mataKuliah)
    {
        return view('mata_kuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|string|max:20|unique:mata_kuliahs,kode_mk,' . $mataKuliah->id,
            'nama_mk' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:6',
            'semester' => 'required|integer|min:1|max:8',
        ]);

        $mataKuliah->update($validated);

        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Data mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();

        return redirect()->route('admin.mata-kuliah.index')->with('success', 'Data mata kuliah berhasil dihapus.');
    }
}