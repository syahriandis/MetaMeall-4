<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResepMakan;

class ResepMakanController extends Controller
{
    // Untuk user umum
    public function index()
    {
        $data = ResepMakan::orderBy('tanggal', 'asc')->get();

        return view('pages.trainer.resepmakan', compact('data'));
    }

    // Untuk trainer
    public function indexTrainer()
    {
        $data = ResepMakan::orderBy('tanggal', 'asc')->get();
        return view('pages.trainer.resepmakan', compact('data'));
    }

    // Untuk trainee
public function indexTrainee()
{
    $data = ResepMakan::orderBy('tanggal', 'asc')->get();
    return view('pages.resepmakan', compact('data'));
}

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenismakanan' => 'required',
            'details' => 'required',
            'kalori' => 'required|integer',
            'status' => 'nullable'
        ]);

        $validated['status'] = $validated['status'] ?? 'not yet';

        $data = ResepMakan::create($validated);
        // dd($data);
        return redirect('/resepmakan/trainer');
        //return response()->json(['message' => 'Data resep berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $resep = ResepMakan::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'jenismakanan' => 'required',
            'details' => 'required',
            'kalori' => 'required|integer',
            'status' => 'nullable'
        ]);

        $validated['status'] = $validated['status'] ?? 'not yet';

        $resep->update($validated);

        return response()->json(['message' => 'Data resep berhasil diperbarui']);
    }

    public function destroy($id)
    {
        $resep = ResepMakan::findOrFail($id);
        $resep->delete();

        return response()->json(['message' => 'Data resep berhasil dihapus']);
    }
}
