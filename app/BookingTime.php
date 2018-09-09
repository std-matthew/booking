<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTime extends Model
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
            'slot' => $this->renderSlot(),
        ];
    }

    /**
     * @Relationships
     */
    
    public function types() {
        return $this->belongsToMany(BookingType::class, 'type_time_pivot', 'type_id', 'time_id');
    }

    public function invoice_items() {
        return $this->hasMany(InvoiceItem::class, 'booking_time_id');
    }

    /**
     * @Helpers
     */
    public function getStartTime()
    {
        $startTime = $this->start_time;
        $start = strtotime($this->start_time);

        if ($start % 3600) {
            $excess = $start % 3600;
            $time = $start - $excess;
            $startTime = date('H:i:s', $time);
        }

        return $startTime;
    }

    public function getEndTime()
    {
        $end_time = $this->end_time;
        $end = strtotime($this->end_time);

        if ($end % 3600) {
            $excess = $end % 3600;
            $excess = 3600 - $excess;
            $time = $end + $excess;
            $end_time = date('H:i:s', $time);
        }

        return $end_time;
    }

    /**
     * @Setters
     */
    public function renderAvailableSlots($date, $location, $type) {
        return BookingReport::getAvailableSlotCount($date, $location, $this, $type);
    }

    /**
     * @Renders
     */
    
    public function renderSlot() {
        return $this->types()->first()->category->limit;
    }
}
