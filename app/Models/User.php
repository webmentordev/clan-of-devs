<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'username', 'avatar', 'email', 'password', 'login_type', 'google_id', 'google_token', 'google_refresh_token', 'google_avatar', 'is_admin', 'is_super_admin', 'is_active', 'is_banned'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function get_avatar(){
        if($this->google_avatar){
            return $this->google_avatar;
        }
        return $this->avatar ? config('app.url'). '/storage/'. $this->avatar : config('app.url'). '/assets/avatar.png';
    }
}