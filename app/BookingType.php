<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingType extends Model
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
    
    public function category() {
        return $this->belongsTo(BookingCategory::class, 'category_id');
    }

    public function times() {
    	return $this->belongsToMany(BookingTime::class, 'type_time_pivot', 'type_id', 'time_id');
    }

    public function invoice_items() {
        return $this->hasMany(InvoiceItem::class, 'booking_type_id');
    }

    /**
     * @Renders
     */
    public function renderPrice($formatted = false) {
        return number_format($this->price, 2, '.', '');
    }
}
