<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail; // Biarkan ini terkomentar jika Anda tidak mengimplementasikan verifikasi email wajib
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Untuk API Tokens (jika menggunakan Sanctum)
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- Import class Attribute
use Illuminate\Support\Facades\Hash;             // <-- Import Facade Hash

class User extends Authenticatable // Bisa juga implements MustVerifyEmail jika diaktifkan
{
    // Trait yang umum digunakan
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Pastikan 'password' ada di sini agar bisa diset saat create/update.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', // Pastikan password ada di $fillable
    ];

    /**
     * Atribut yang seharusnya disembunyikan saat serialisasi (misal saat dikirim sebagai JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang seharusnya di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        // Anda TIDAK PERLU lagi menambahkan 'password' => 'hashed' di sini
        // jika sudah menggunakan method password() di bawah.
    ];

    /**
     * Berinteraksi dengan password pengguna.
     * Method ini akan secara otomatis melakukan hashing pada nilai password
     * setiap kali Anda mencoba mengeset atribut 'password' pada model User.
     *
     * Contoh:
     * $user = new User;
     * $user->password = 'password123'; // <- 'password123' akan otomatis di-hash
     * $user->save();
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function password(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => $value, // Getter biasanya tidak diperlukan untuk password
            set: fn($value) => Hash::make($value), // Setter: otomatis hash nilai yang diberikan
        );
    }

    // Anda bisa menambahkan relasi Eloquent atau method lain di sini
    // Contoh:
    // public function posts()
    // {
    //     return $this->hasMany(Post::class);
    // }
}
