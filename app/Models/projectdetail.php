<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Projectdetail extends Model
{
    protected $table = 'project_details';

    protected $fillable = [
        'project_id', 'operational_id',
        'scope_of_work', 'tools_materials',
        'start_date', 'end_date', 'notes',
        'material', 'alat_kerja',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function operational()
    {
        return $this->belongsTo(User::class, 'operational_id');
    }
}