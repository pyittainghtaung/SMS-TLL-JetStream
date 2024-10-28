<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nette\Utils\Strings;

class Grade extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'grades';
    protected $fillable = ['academic_id', 'name'];

    protected $dates = ['deleted_at'];

    public function academic(): BelongsTo
    {
        return $this->belongsTo(Academic::class);
    }
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function scopeFilterByAcademicAndGrade(Builder $query, $academicId, string $search): Builder
    {
        return $query->where('academic_id', $academicId)->where('name', 'like', '%' . $search . '%');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($grade) {
            // Check if the academic instance is being permanently deleted
            if ($grade->isForceDeleting()) {
                // If force deleting, permanently delete related grades
                $grade->sections()->forceDelete();
            } else {
                // If soft deleting, just soft delete related grades
                $grade->sections()->delete();
            }
        });
        // Handle restore event to restore the grades
        static::restoring(function ($grade) {
            $grade->sections()->withTrashed()->restore();
        });
    }
}
