<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'discount_percentage',
        'is_active',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_membership')
            ->withPivot('start_date', 'end_date', 'is_active')
            ->withTimestamps();
    }
}
