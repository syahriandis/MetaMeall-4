<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramLatihan;

class ProgramLatihanController extends Controller
{
    public function programlatihan_trainer()
    {
        $data = ProgramLatihan::orderBy('tanggal', 'asc')->get();
        return view('pages.trainer.programlatihan', compact('data'));
    }

    public function programlatihan()
    {
        $data = ProgramLatihan::orderBy('tanggal', 'asc')->get();
        return view('pages.programlatihan', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenis_latihan' => 'required',
            'details' => 'required',
            'status' => 'nullable'
        ]);

        $validated['status'] = $validated['status'] ?? 'belum';

        ProgramLatihan::create($validated);

        return response()->json(['message' => 'Data berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $program = ProgramLatihan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenis_latihan' => 'required',
            'details' => 'required',
            'status' => 'nullable'
        ]);

        $validated['status'] = $validated['status'] ?? 'belum';

        $program->update($validated);

        return response()->json(['message' => 'Data diperbarui']);
    }

    public function destroy($id)
    {
        $program = ProgramLatihan::findOrFail($id);
        $program->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }
}
