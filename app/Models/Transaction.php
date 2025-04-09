<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'games_package_id',
        'transaction_id',
        'game_username',
        'game_user_id',
        'game_server',
        'amount',
        'discount_amount',
        'total_amount',
        'status',
        'payment_details',
    ];

    protected $casts = [
        'payment_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gamesPackage()
    {
        return $this->belongsTo(GamesPackage::class);
    }
}