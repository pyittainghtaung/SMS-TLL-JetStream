<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'students';
    protected $fillable = [
        'academic_id',
        'accepted_student_id',
        'spa_student_id',
        'name',
        'gender',
        'student_nrc_no',
        'student_dob',
        'ethnic',
        'religion',
        'father_name',
        'father_nrc_no',
        'mother_name',
        'mother_nrc_no',
        'father_job',
        'mother_job',
        'wanted_class',
        'address',
        'contact_phone_no',
        'passed_grade_and_roll_no',
        'passed_school_name',
        'passed_year',
        'passed_town_name',
        'enter_date',
        'available_people',
        'image',
    ];
    protected $dates = ['deleted_at'];

    public function academic(): BelongsTo
    {
        return $this->belongsTo(Academic::class);
    }

    public function scopeFilterByAcademicAndName(Builder $query, $academicId, string $search): Builder
    {
        return $query->where('academic_id', $academicId)->where('name', 'like', '%' . $search . '%');
    }
}
