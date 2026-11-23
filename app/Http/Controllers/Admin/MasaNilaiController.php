<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class MasaNilaiController extends Controller
{
    public function index()
    {
        return view('admin.masa-nilai.index', ['dibuka' => Pengaturan::nilaiDibuka()]);
    }

    public function update(Request $request)
    {
        $buka = $request->boolean('buka');
        Pengaturan::setNilaiDibuka($buka);

        return back()->with('success', $buka ? 'Masa input nilai dibuka.' : 'Masa input nilai ditutup.');
    }
}