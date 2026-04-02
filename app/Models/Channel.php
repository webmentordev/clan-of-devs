<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'workspace_id', 'is_deletable', 'type', 'is_private', 'slug', 'unique_id', 'user_id'])]
class Channel extends Model
{
    //
}