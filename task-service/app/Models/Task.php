<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'due_date',
        'user_id', // Could be an FK, but with this microservice approach,
        // I decided to validate through the token's claim (sub)
    ];
}
