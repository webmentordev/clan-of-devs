<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'unique_id', 'description', 'logo', 'is_active', 'user_id', 'is_deleted'])]
class Workspace extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}