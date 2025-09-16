<?php

namespace App\Http\Controllers;

use App\Models\KategoriSurat;
use Illuminate\Http\Request;

class KategoriSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = KategoriSurat::orderBy('nama_kategori')->get();
        return view('kategori-surat.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kategori-surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_surats',
            'deskripsi' => 'nullable|string'
        ]);

        KategoriSurat::create($request->all());

        return redirect()->route('kategori-surat.index')
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategoriSurat $kategoriSurat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategoriSurat $kategoriSurat)
    {
        return view('kategori-surat.edit', compact('kategoriSurat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategoriSurat $kategoriSurat)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori_surats,nama_kategori,' . $kategoriSurat->id,
            'deskripsi' => 'nullable|string'
        ]);

        $kategoriSurat->update($request->all());

        return redirect()->route('kategori-surat.index')
            ->with('success', 'Kategori berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategoriSurat $kategoriSurat)
    {
        if ($kategoriSurat->arsipSurats->count() > 0) {
            return redirect()->back()
                ->with('error', 'Kategori tidak dapat dihapus karena masih digunakan');
        }

        $kategoriSurat->delete();

        return redirect()->route('kategori-surat.index')
            ->with('success', 'Kategori berhasil dihapus');
    }
}
