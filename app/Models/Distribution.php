<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = [
        'mustahik_id',
        'program',
        'amount',
        'distribution_date',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
