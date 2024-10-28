<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academic extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'academics';

    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];

    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
    public function hostels(): HasMany
    {
        return $this->hasMany(Hostel::class);
    }
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    // Local Query Scope Methods Start Here
    public function scopeSearchByName(Builder $query, string $search): Builder
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }


    //  Add Addtional Local Query Scope Methods Here

    // Local Query Scope Methods Ends Here


    public static function boot()
    {
        parent::boot();

        static::deleting(function ($academic) {
            // Check if the academic instance is being permanently deleted
            if ($academic->isForceDeleting()) {
                // If force deleting, permanently delete related grades
                $academic->grades()->forceDelete();
                $academic->sections()->forceDelete();
                $academic->hostels()->forceDelete();
            } else {
                // If soft deleting, just soft delete related grades
                $academic->grades()->delete();
                $academic->sections()->delete();
                $academic->hostels()->delete();
            }
        });
        // Handle restore event to restore the grades
        static::restoring(function ($academic) {
            $academic->grades()->withTrashed()->restore();
            $academic->sections()->withTrashed()->restore();
            $academic->hostels()->withTrashed()->restore();
        });
    }
}
