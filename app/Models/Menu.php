<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
<<<<<<< HEAD
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'is_available',
        'categories', // tambahkan ini
    ];

    protected $casts = [
        'categories' => 'array',
    ];
=======
    //
>>>>>>> 11bef3afaaf72c1e50919d38cee6d046b0ef42c6
}
