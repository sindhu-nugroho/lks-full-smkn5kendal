<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'user_id', 
        'tgl_pinjam', 
        'tgl_jatuh_tempo', 
        'status', 
        'denda'
    ];

    // Jika kamu punya relasi ke User dan Book, pastikan sudah ada juga
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function books() {
        return $this->details();
    }

    public function details() // Tambahkan ini agar controller tidak error
{
    return $this->belongsToMany(Book::class, 'book_transaction', 'transaction_id', 'book_id')->withTimestamps();
}
}
