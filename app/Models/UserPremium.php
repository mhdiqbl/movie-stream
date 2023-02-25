<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPremium extends Model
{
    use HasFactory;

    protected $fillable = [
        'packages_id',
        'user_id',
        'end_of_subscription',
    ];
}
