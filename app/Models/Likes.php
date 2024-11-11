<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
    use HasFactory;

    protected $table = 'likes';

    protected $fillable = [
        'user_id',
        'posting_id',
        'create_by',
        'update_date',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function postings()
    {
        return $this->belongsTo(Postings::class);
    }
}
