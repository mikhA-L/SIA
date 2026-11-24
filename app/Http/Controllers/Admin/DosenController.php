<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');
        $data = Dosen::when($q, fn ($query) => $query
                ->where('nidn', 'like', "%$q%")
                ->orWhere('nama', 'like', "%$q%"))
            ->orderBy('nama')->paginate(10)->withQueryString();

        return view('admin.dosen.index', compact('data', 'q'));
    }

    public function create()
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
        'nidn'     => ['required', 'string', 'max:20', 'unique:dosen,nidn', 'unique:users,username'],
        'nama'     => ['required', 'string', 'max:100'],
        'email'    => ['required', 'email', 'max:100', 'unique:users,email'],
        'password' => ['required', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name'     => $data['nama'],
                'username' => $data['nidn'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
                'role'     => 'dosen',
            ]);

            Dosen::create([
                'nidn'    => $data['nidn'],
                'nama'    => $data['nama'],
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('admin.dosen.index')->with('success', 'Dosen dan akun login ditambahkan.');
    }

    public function edit(Dosen $dosen)
    {
        $data = $this->validated($request, $dosen->id);
        $dosen->update($data);
        $dosen->user?->update(['name' => $data['nama']]);

        return redirect()->route('admin.dosen.index')->with('success', 'Data diperbarui.');
    }


    public function update(Request $request, Dosen $dosen)
    {
        $dosen->update($this->validated($request, $dosen->id));
        return redirect()->route('admin.dosen.index')->with('success', 'Data diperbarui.');
    }

    public function destroy(Dosen $dosen)
    {
        DB::transaction(function () use ($dosen) {
            $user = $dosen->user;
            $dosen->delete();
            $user?->delete();
        });

        return redirect()->route('admin.dosen.index')->with('success', 'Data dan akun dihapus.');
    }

    private function validated(Request $request, $ignoreId = null): array
    {
        return $request->validate([
            'nidn' => ['required', 'string', 'max:20', Rule::unique('dosen', 'nidn')->ignore($ignoreId)],
            'nama' => ['required', 'string', 'max:100'],
        ]);
    }
}