<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    /**
     * @var string
     */
    protected $primaryKey = 'hotel_id';

    /**
     * @var array
     */
    protected $guarded = ['hotel_id'];

    /**
     * @return BelongsTo
     */
    public function prefecture(): BelongsTo
    {
        return $this->belongsTo(Prefecture::class, 'prefecture_id', 'prefecture_id');
    }

    /**
     * @return hasMamy
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'hotel_id');
    }

    /**
     * Search hotel by hotel name
     *
     * @param string $hotelName
     * @return array
     */
    static public function getHotelListByName(string $hotelName): array
    {
        $result = Hotel::where('hotel_name', 'like', '%' . $hotelName . '%')
            ->with('prefecture')
            ->get()
            ->toArray();

        return $result;
    }

    /**
     * Search hotel by hotel name and prefecture
     *
     * @param string $hotelName
     * @param string $prefecture_id
     * @return array
     */
    static public function getHotelListByNameAndPrefectureId(string $hotelName, string $prefectureId): array
    {
        $result = Hotel::where('hotel_name', 'like', '%' . $hotelName . '%')
            ->where('prefecture_id', '=', $prefectureId)
            ->with('prefecture')
            ->get()
            ->toArray();

        return $result;
    }

    /**
     * Override serializeDate method to customize date format
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Get path image with id hotel
     * 
     * @param string $hotel_id
     * @return string
     */
    static public function getPathImageWithId(string $hotel_id): string
    {
        $result = Hotel::select('file_path')
            ->where('hotel_id', $hotel_id)
            ->value('file_path');

        return $result;
    }

    protected $fillable = ['hotel_id', 'hotel_name', 'prefecture_id', 'file_path'];
}
