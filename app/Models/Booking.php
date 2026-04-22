<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'trip_id', 'reference', 'name', 'email', 'phone',
        'adults', 'children', 'travel_date', 'payment_method',
        'total_price', 'notes', 'status', 'confirmed_at',
    ];

    protected $casts = [
        'travel_date'  => 'date',
        'confirmed_at' => 'datetime',
        'total_price'  => 'decimal:2',
    ];

    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'credit_card'   => 'بطاقة ائتمان',
            'visa'          => 'فيزا',
            'meeza'         => 'ميزة',
            'instapay'      => 'إنستا باي',
            'vodafone_cash' => 'فودافون كاش',
            default         => $this->payment_method,
        };
    }
}
