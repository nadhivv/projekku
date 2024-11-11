<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postings extends Model
{
    use HasFactory;

    protected $table = 'postings';

    protected $fillable = [
        'user_id',
        'message',
        'message_gambar',
        'create_by',
        'update_by',
        'update_date',
    ];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Likes::class, 'posting_id');
    }
    public function komens()
    {
        return $this->hasMany(Komens::class, 'posting_id');
    }

    public function menus()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
