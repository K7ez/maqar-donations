<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryFamily extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_name',
        'national_id',
        'members_count',
        'housing_program',
        'status',
    ];
}
