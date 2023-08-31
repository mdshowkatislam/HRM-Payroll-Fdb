<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrmClient extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'serial',
        'name',
        'email',
        'phone',
        'image',
        'country',
        'address',
        'website',
        'contact_person',
        'contact_person_email',
        'contact_person_phone',
        'company',
        'company_type',
        'company_address',
        'status',
        'created_by',
        'updated_by',
    ];

    public function createdByName()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function updatedByName()
    {
        return $this->belongsTo(User::class,'updated_by');
    }
}
