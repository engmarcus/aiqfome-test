<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $table = 'client.clients';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function favorites()
    {
        return $this->hasMany(FavoriteProduct::class);
    }


     public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'client_id' => $this->id,
            'email'     => $this->email,
            'role'      => 'client',
            'remember_token' => $this->remember_token
        ];
    }
}
