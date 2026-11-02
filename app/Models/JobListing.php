<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Relations\HasMany;


class JobListing extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'slug',
        'description',
        'location',
        'type',
        'salary_min',
        'salary_max',
        'is_featured',
        'status',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }
}