<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'unique_id', 'description', 'avatar', 'is_active', 'user_id', 'is_deleted'])]
class Workspace extends Model
{
    //
}