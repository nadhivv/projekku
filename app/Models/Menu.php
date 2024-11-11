<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'menu_name',
        'menu_link',
        'menu_icon',
        'parent_id',
        'create_by',
        'delete_mark',
        'update_by'
    ];


    public function menus()
    {
        return $this->hasMany(Menu::class, 'id_level');
    }

    public function jenisUsers()
    {
        return $this->belongsToMany(JenisUsers::class, 'setting_menu_users', 'menu_id', 'id_jenis_user');
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'setting_menu_users', 'menu_id', 'id_jenis_user');
}
}

