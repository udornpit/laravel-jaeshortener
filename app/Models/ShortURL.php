<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortURL extends Model
{
    use HasFactory;

    protected $table = 'shorturls';

    protected $fillable = [
        'key',
        'dest',
        'short',
        'visit',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
