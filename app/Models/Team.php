<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function teamLead(): HasOne
    {
        return $this->hasOne(User::class)->whereHas('roles', function ($query) {
            $query->where('name', 'team-lead');
        });
    }
} 