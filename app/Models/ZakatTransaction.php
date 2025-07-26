<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZakatTransaction extends Model
{
    protected $fillable = [
        'muzakki_id',
        'types_of_zakat',
        'amount',
        'zakat_transaction_date',
        'proof_of_payment',
        'notes',
        'created_by',
        'updated_by',
    ];

    public function muzakki()
    {
        return $this->belongsTo(Muzakki::class);
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
