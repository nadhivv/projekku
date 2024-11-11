<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bukus extends Model
{
    use HasFactory;

    protected $table = 'bukus';
    protected $fillable = ['judul', 'kode', 'pengarang','created_by', 'id_kategori'];

    public function kategori()
{
    return $this->belongsTo(Kategoris::class, 'id_kategori');
}
}
