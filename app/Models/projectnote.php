<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectnote extends Model
{
    protected $table = 'project_notes';

    protected $fillable = ['project_id', 'owner_id', 'note', 'type'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}