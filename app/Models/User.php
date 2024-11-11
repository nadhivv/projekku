<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;


     protected $table = 'users';
     protected $fillable = [
        'nama_user',
        'username',
        'email',
        'password',
        'no_hp',
        'id_jenis_user',
        'status_user',
        'delete_mark',
        'create_by',
        'update_by'

    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function jenisUser()
    {
        return $this->belongsTo(JenisUsers::class, 'id_jenis_user');
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'setting_menu_users', 'id_jenis_user', 'menu_id');
    }
}
