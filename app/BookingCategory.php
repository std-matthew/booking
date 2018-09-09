<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingCategory extends Model
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
    
    public function locations() {
        return $this->belongsToMany(BookingLocation::class, 'location_category_pivot', 'location_id', 'category_id');
    }

    public function types() {
    	return $this->hasMany(BookingType::class, 'category_id');
    }

    public function invoice_items() {
        return $this->hasMany(InvoiceItem::class, 'booking_category_id');
    }
}
