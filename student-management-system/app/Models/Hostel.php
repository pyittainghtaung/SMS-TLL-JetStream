<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hostel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'hostels';
    protected $fillable = ['academic_id', 'name','address','phone_no'];
    protected $dates = ['deleted_at'];

    public function academic(): HasOne
    {
        return $this->hasOne(Academic::class);
    }
}
