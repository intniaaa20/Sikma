<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'poster_path',
        'start_date',
        'end_date',
        'discount',
    ];

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_promo');
    }
}
