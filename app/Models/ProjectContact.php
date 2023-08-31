<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectContact extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'project_id',
        'name',
        'email',
        'phone',
        'image',
        'designation',
        'country',
        'address',
        'website',
        'status',
        'created_by',
        'updated_by',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
