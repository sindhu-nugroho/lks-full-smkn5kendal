<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'book_id'];

    public function book() {
        return $this->belongsTo(Book::class, 'books_id');
    }
}
