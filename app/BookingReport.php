<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingReport extends Model
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
     * @Methods
     */

    public static function store(Invoice $invoice) {
    	foreach ($invoice->items as $item) {
    	 	$ids = $item->getBookingIds();

    	 	$report = BookingReport::where($ids)->first();

    	 	if (!$report) {
    	 		$report = BookingReport::create($ids);
    	 	}

    	 	$report->quantity += $item->quantity;
    	 	$report->save();
    	 } 
    }

    /**
     * @Checkers
     */
    
    public static function getReport($date = null, $location = null, $category = null) {

    	$query = static::get();

    	/* Check and filter by date */
    	if($date)
    		$query = $query->where('booking_date', $date);

    	/* Check and filter by location */
    	if($location)
    		$query = $query->where('booking_location_id', $location->id);

    	/* Check and filter by category */
    	if($category)
    		$query = $query->where('booking_category_id', $category->id);

    	return $query;
    }

    public static function isUnavailable($date, $locationId = null)
    {
        $hasBooking = static::getReport($date)->count();
        
        if (!$hasBooking) {
            return false;
        }

        $location = BookingLocation::find($locationId);
        $isUnavailable = true;
        $categories = $location->categories;

        foreach ($categories as $category) {
            foreach ($category->types as $type) {
                foreach ($type->times as $time) {
                    if (!static::isTimeUnavailable($date, $location, $time, $type)) {
                        $isUnavailable = false;
                        break;
                    }
                }
            }
        }

        return $isUnavailable;
    }

    public static function isTimeUnavailable($date, $location, $time, $type, $quantity = 0, $noCart = true)
    {   
        # Set to variable data needed
        $category = $type->category;
        $isUnavailable = false;

        $availableSlots = BookingReport::getAvailableSlotCount($date, $location, $time, $type, $quantity);

        # Check if there is any available slots
        if ($availableSlots <= 0) {
            $isUnavailable = true;
        }

        return $isUnavailable;
    }
    
    public static function getAvailableSlotCount($date, $location, $time, $type, $quantity = 0, $noInvoice = false)
    {
        # Set to variable data needed
        $timeIds = [];
        $times = BookingTime::all();
        $startTime = $time->getStartTime();
        $endTime = $time->getEndTime();

        # Check which times intersects then store into an array intersected ids
        foreach ($times as $report) {
            if ($report->getStartTime() < $endTime && 
                $report->getStartTime() >= $startTime) 
            {
                array_push($timeIds, $report->id);
            } else if ($startTime < $report->getEndTime() && 
                $startTime >= $report->getStartTime()) {
                array_push($timeIds, $report->id);
            }
        }

        # Number of Tickets
        $reportQuantity = 0;

	    $category = $type->category;

        $reports = BookingReport::where([
        	'booking_date' => $date, 
        	'booking_location_id' => $location->id, 
        	'booking_category_id' => $category->id,
        ]);

        # Get the sum of invoice number of tickets with the intersected times
        $reportQuantity = $reports->whereIn('booking_time_id', $timeIds)->sum('quantity') + $quantity;


        if ($noInvoice) {
            $invoice = Invoice::getActiveInvoice();

            $items = $invoice->items->where([
            	'booking_date' => $date,
            	'booking_location_id' => $location->id,
            	'booking_category_id' => $type->category->id,
            ])
            ->whereIn('booking_time_id', $timeIds)
         	->get();

            $quantity = 0;

            if (count($items)) {
                $quantity = $items->sum('qty');
            }

            $reportQuantity = $reportQuantity + $quantity;
        }

        $limit = $category->limit;
        $availableSlots = $limit - $reportQuantity;

        return $availableSlots;
    }
}
