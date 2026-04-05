<?php

namespace App\Models;

use App\Models\Workspace;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug'])]
class WorkspaceCategory extends Model
{
    public function workspaces()
    {
        return $this->hasMany(Workspace::class);
    }
}