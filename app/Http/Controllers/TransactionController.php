<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction; // Penting untuk import model
use App\Models\Book;
use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'anggota') {
            $transactions = Transaction::with('details.book')
                            ->where('user_id', Auth::id())
                            ->latest()
                            ->get();
        } else {
            $transactions = Transaction::with(['user', 'details'])
                            ->latest()
                            ->get();
        }

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Menampilkan form peminjaman (Hanya Admin/Superadmin)
     */
    public function create()
    {
        $books = Book::where('stok', '>', 0)->get();
        $users = User::where('role', 'anggota')->get();
        return view('transactions.create', compact('books', 'users'));
    }

    /**
     * Menyimpan transaksi peminjaman (Hanya Admin/Superadmin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'book_ids' => 'required|array|min:1',
        ]);

        // Aturan: Maksimal 3 buku sekali transaksi
        if (count($request->book_ids) > 3) {
            return back()->with('error', 'Gagal! Maksimal peminjaman adalah 3 buku.');
        }

        // Simpan Data Transaksi
        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'tgl_pinjam' => now(),
            'tgl_jatuh_tempo' => now()->addDays(7),
            'status' => 'pinjam',
            'denda' => 0
        ]);

        // Simpan Detail & Kurangi Stok
        foreach ($request->book_ids as $book_id) {
        $transaction->details()->attach($book_id);

        // Kurangi stok buku secara otomatis
        \App\Models\Book::find($book_id)->decrement('stok');
        }

        return redirect()->route('transaksi.index')->with('success', 'Buku berhasil dipinjam.');
    }

    /**
     * Proses Pengembalian & Hitung Denda (Hanya Admin/Superadmin)
     */
    public function returnBook($id)
    {
        $transaction = Transaction::findOrFail($id);
        
        if ($transaction->status == 'kembali') {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $tgl_kembali = now(); // Gunakan carbon untuk tanggal hari ini
        $tgl_jatuh_tempo = \Carbon\Carbon::parse($transaction->tgl_jatuh_tempo);
        $denda = 0;

        // Hitung denda jika terlambat
        if ($tgl_kembali->gt($tgl_jatuh_tempo)) {
            $selisih_hari = $tgl_kembali->diffInDays($tgl_jatuh_tempo);
            $denda = $selisih_hari * 1000;
        }

        // Update status transaksi
        $transaction->update([
            'tgl_kembali' => $tgl_kembali,
            'denda' => $denda,
            'status' => 'kembali'
        ]);

        // Kembalikan stok buku
        foreach ($transaction->details as $detail) {
            Book::find($detail->book_id)->increment('stok');
        }

        return redirect()->route('transaksi.index')->with('success', 'Buku berhasil dikembalikan. Denda: Rp ' . number_format($denda));
    }

    /**
     * Menampilkan detail transaksi
     */
    public function show($id)
    {
        $transaction = Transaction::with(['user', 'details.book'])->findOrFail($id);
        
        // Proteksi: Anggota tidak bisa melihat detail milik orang lain
        if (Auth::user()->role == 'anggota' && $transaction->user_id != Auth::id()) {
            abort(403);
        }

        return view('transactions.show', compact('transaction'));
    }
}
