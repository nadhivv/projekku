<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoris extends Model
{
    use HasFactory;
    protected $table = 'kategoris';
    protected $fillable = ['nama_kategori'];

    public function buku()
    {
        return $this->hasMany(Bukus::class);
    }

}
