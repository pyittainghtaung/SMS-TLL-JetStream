<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hostel extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'hostels';
    protected $fillable = ['academic_id', 'name', 'address', 'phone_no'];
    protected $dates = ['deleted_at'];

    public function academic(): BelongsTo
    {
        return $this->belongsTo(Academic::class);
    }

    public function scopeFilterByAcademicAndHostel(Builder $query, $academicId, string $search): Builder
    {
        return $query->where('academic_id', $academicId)->where('name', 'like', '%' . $search . '%');
    }
}
