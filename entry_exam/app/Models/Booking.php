<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
