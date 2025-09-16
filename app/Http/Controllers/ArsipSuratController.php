<?php

namespace App\Http\Controllers;

use App\Models\ArsipSurat;
use App\Models\KategoriSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipSuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ArsipSurat::with('kategoriSurat');

        if ($request->has('search') && $request->search != '') {
            $query->where('judul_surat', 'like', '%' . $request->search . '%');
        }

        $arsipSurats = $query->orderBy('created_at', 'desc')->get();

        return view('arsip-surat.index', compact('arsipSurats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = KategoriSurat::all();
        return view('arsip-surat.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'tanggal_surat' => 'required|date',
            'deskripsi' => 'nullable|string',
            'file_pdf' => 'required|mimes:pdf|max:10240'
        ]);

        $fileName = time() . '_' . $request->file('file_pdf')->getClientOriginalName();
        $filePath = $request->file('file_pdf')->storeAs('pdf', $fileName, 'public');

        ArsipSurat::create([
            'judul_surat' => $request->judul_surat,
            'kategori_id' => $request->kategori_id,
            'tanggal_surat' => $request->tanggal_surat,
            'deskripsi' => $request->deskripsi,
            'file_pdf' => $filePath
        ]);

        return redirect()->route('arsip-surat.index')
            ->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(ArsipSurat $arsipSurat)
    {
        return view('arsip-surat.show', compact('arsipSurat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArsipSurat $arsipSurat)
    {
        $kategoris = KategoriSurat::all();
        return view('arsip-surat.edit', compact('arsipSurat', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArsipSurat $arsipSurat)
    {
        $request->validate([
            'judul_surat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_surats,id',
            'tanggal_surat' => 'required|date',
            'deskripsi' => 'nullable|string',
            'file_pdf' => 'nullable|mimes:pdf|max:10240'
        ]);

        $updateData = [
            'judul_surat' => $request->judul_surat,
            'kategori_id' => $request->kategori_id,
            'tanggal_surat' => $request->tanggal_surat,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('file_pdf')) {
            // Hapus file lama
            Storage::disk('public')->delete($arsipSurat->file_pdf);

            // Upload file baru
            $fileName = time() . '_' . $request->file('file_pdf')->getClientOriginalName();
            $filePath = $request->file('file_pdf')->storeAs('pdf', $fileName, 'public');
            $updateData['file_pdf'] = $filePath;
        }

        $arsipSurat->update($updateData);

        return redirect()->route('arsip-surat.index')
            ->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArsipSurat $arsipSurat)
    {
        // Hapus file PDF
        Storage::disk('public')->delete($arsipSurat->file_pdf);

        $arsipSurat->delete();

        return redirect()->route('arsip-surat.index')
            ->with('success', 'Data berhasil dihapus');
    }

    // Di ArsipSuratController.php
    public function download(ArsipSurat $arsipSurat)
    {
        $filePath = storage_path('app/public/' . $arsipSurat->file_pdf);

        if (!file_exists($filePath)) {
            return back()->with('error', 'File PDF tidak ditemukan');
        }

        return response()->download($filePath);
    }
}
