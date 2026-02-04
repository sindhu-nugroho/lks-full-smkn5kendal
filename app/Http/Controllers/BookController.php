<?php

namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
// 1. Validasi input dan masukkan ke variabel $validated
    $validated = $request->validate([
        'judul' => 'required|string|max:255',
        'isbn'  => 'required|unique:books,isbn',
        'stok'  => 'required|numeric|min:0'
    ]);

    // 2. Simpan hanya data yang lolos validasi (aman dari field _token)
    \App\Models\Book::create($validated);

    // 3. Redirect kembali dengan pesan sukses
    return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambah.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('books.edit', compact('buku'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required',
            'isbn'  => 'required',
            'stok' => 'required|numeric'
        ]);

        // PERBAIKAN: Cari dulu datanya berdasarkan ID
        $buku = Book::findOrFail($id);

        $buku->update($request->all());
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // PERBAIKAN: Cari dulu datanya berdasarkan ID
        $buku = Book::findOrFail($id);

        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
