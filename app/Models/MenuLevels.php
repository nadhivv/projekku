<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuLevels extends Model
{
    use HasFactory;

    protected $table = 'menu_levels';

    protected $fillable = [
        'menu_name',
        'menu_link',
        'menu_icon',
        'parent_id',
        'create_by',
        'delete_mark',
        'update_by'
    ];
    public function menuLevel()
{
    return $this->belongsTo(MenuLevels::class, 'id_level'); // Berhubungan dengan tabel 'menu_levels'
}

}
