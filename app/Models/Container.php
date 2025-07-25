<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    use HasFactory;

    protected $fillable = [
        'container_id',
        'name',
        'image',
        'status',
        'ports',
        'user_id'
    ];

    protected $casts = [
        'ports' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
