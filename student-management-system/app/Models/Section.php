<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'sections';
    protected $fillable = ['academic_id', 'grade_id', 'name'];

    protected $dates = ['deleted_at'];

    public function academic(): BelongsTo
    {
        return $this->belongsTo(Academic::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function scopeFilterByGradeAndSection(Builder $query, $gradeId, string $search): Builder
    {
        return $query->where('grade_id', $gradeId)->where('name', 'like', '%' . $search . '%');
    }
}
