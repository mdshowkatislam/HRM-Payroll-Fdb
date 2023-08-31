<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'hrm_client_id',
        'project_id',
        'is_permitted',
        'created_by',
        'updated_by',
    ];
}
