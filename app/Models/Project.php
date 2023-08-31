<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'hrm_client_id',
        'serial',
        'project_fdb_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'created_by',
        'updated_by',
    ];



    public function hrmClient()
    {
        return $this->belongsTo(HrmClient::class);
    }

    public function projectContacts()
    {
        return $this->belongsTo(ProjectContact::class,'project_id');
    }
}
