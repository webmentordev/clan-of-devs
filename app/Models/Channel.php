<?php

namespace App\Models;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'workspace_id', 'is_deletable', 'type', 'is_private', 'slug', 'unique_id', 'user_id'])]
class Channel extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}