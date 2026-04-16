<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_openings';

    protected $fillable = [
        'company_id',
        'category_id',
        'title',
        'description',
        'deadline',
        'salary_min',
        'salary_max',
        'location',
        'job_type',
        'experience_level',
        'requirements',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
