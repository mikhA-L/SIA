<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $data = Mahasiswa::when($q, fn ($query) => $query
                ->where('nim', 'like', "%$q%")
                ->orWhere('nama', 'like', "%$q%"))
            ->orderBy('nim')
            ->paginate(10)
            ->withQueryString();

        return view('admin.mahasiswa.index', compact('data', 'q'));
    }

    public function create()
    {
        return view('admin.mahasiswa.create');
    }

    public function store(Request $request)
    {
        Mahasiswa::create($this->validated($request));
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Mahasiswa ditambahkan.');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('admin.mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($this->validated($request, $mahasiswa->id));
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data dihapus.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'nim'      => ['required', 'string', 'max:20', Rule::unique('mahasiswa', 'nim')->ignore($ignoreId)],
            'nama'     => ['required', 'string', 'max:100'],
            'prodi'    => ['required', 'string', 'max:100'],
            'angkatan' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . date('Y')],
        ]);
    }
}