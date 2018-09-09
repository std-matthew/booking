<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingLocation extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['extra'];

    /**
     * Append values
     * @return array
     */
    public function getExtraAttribute() {
        return $this->attributes['extra'] = [

        ];
    }

    /**
     * @Relationships
     */
    
    public function categories() {
        return $this->belongsToMany(BookingCategory::class, 'location_category_pivot', 'category_id', 'location_id');
    }

    public function invoice_items() {
        return $this->hasMany(InvoiceItem::class, 'booking_location_id');
    }
}
