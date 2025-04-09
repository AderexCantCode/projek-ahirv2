<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description', 
        'image',
        'is_active',
    ];

    protected $packages;

    public function packages()
    {
        return $this->hasMany(GamesPackage::class);
    }

    public function getPackages()
    {
        return $this->packages;
    }

    public function setPackages($packages)
    {
        $this->packages = $packages;
    }
}