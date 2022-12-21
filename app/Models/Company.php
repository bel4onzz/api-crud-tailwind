<?php

namespace App\Models;

use App\Models\Gig;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gigs()
    {
        return $this->hasMany(Gig::class);
    }
}
