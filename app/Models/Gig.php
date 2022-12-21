<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gig extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'start',
        'end',
        'number_of_position',
        'pay_per_hour',
        'status',
    ];

    protected function start(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => date_format(Carbon::parse($value),"Y-m-d H:i:s"),
        );
    }
    protected function end(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => date_format(Carbon::parse($value),"Y-m-d H:i:s"),
        );
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
