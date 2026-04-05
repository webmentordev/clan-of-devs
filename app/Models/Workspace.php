<?php

namespace App\Models;

use App\Models\Channel;
use App\Models\User;
use App\Models\WorkspaceCategory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'unique_id', 'workspace_category_id', 'description', 'logo', 'is_active', 'user_id', 'is_deleted'])]
class Workspace extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channels()
    {
        return $this->hasMany(Channel::class);
    }

    public function general_chat()
    {
        return $this->hasOne(Channel::class)->where('title', 'general');
    }

    public function category()
    {
        return $this->belongsTo(WorkspaceCategory::class);
    }
}