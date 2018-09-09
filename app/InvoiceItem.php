<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
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
    
    public function invoice() {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function location() {
        return $this->belongsTo(BookingLocation::class, 'booking_location_id');
    }

    public function category() {
        return $this->belongsTo(BookingCategory::class, 'booking_category_id');
    }

    public function type() {
        return $this->belongsTo(BookingType::class, 'booking_type_id');
    }

    public function time() {
        return $this->belongsTo(BookingTime::class, 'booking_time_id');
    }

     /**
     * @Helpers
     */
    
    public function getBookingIds($except = []) {

        $arr = [
            'booking_location_id' => $this->booking_location_id,
            'booking_category_id' => $this->booking_category_id,
            'booking_type_id' => $this->booking_type_id,
            'booking_time_id' => $this->booking_time_id,
            'booking_date' => $this->booking_date,
        ];

        if (is_array($except)) {
            foreach ($except as $column) {
                unset($arr[$column]);
            }
        }

        return $arr;
    }

    /**
     * @Methods
     */
    
    public static function store($request) {
        $invoice = Invoice::getActiveInvoice();

        $ids = $request->except(['quantity']);

        $locationId = $request->input('booking_location_id');
        $typeId = $request->input('booking_type_id');
        $timeId = $request->input('booking_time_id');

        $type = BookingType::find($typeId);

        $categoryId = $type->category->id;

        $ids['booking_category_id'] = $categoryId;

        $vars = [];
        $vars['price'] = $type->renderPrice();
        $vars['quantity'] = $request->input('quantity');

        $invoice->items()->updateOrCreate($ids, $vars);
    }
}
