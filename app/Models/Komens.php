<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komens extends Model
{
    use HasFactory;

    protected $table = 'komens';

    protected $fillable = [
        'user_id',
        'posting_id',
        'komen',
        'create_by',
        'update_date',
    ];

    // Define the relationship with User
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function postings()
    {
        return $this->belongsTo(Postings::class);
    }
}

