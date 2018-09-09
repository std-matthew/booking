<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers;

class Invoice extends Model
{
    use SoftDeletes;

    public $message = 'No item found, cannot proceed.';
    public $action = false;
    public $redirectUrl = '';

    protected $guarded = [];
    protected $appends = ['extra'];

    const PENDING = 0;
    const PAID = 1;

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
    
    public function items() {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /**
     * @Methods
     */
    
    public static function getActiveInvoice() {
		$invoice = Invoice::where('status', Invoice::PENDING)->first();

		if (!$invoice) {
			$invoice = Invoice::create();
		}

		return $invoice;
	}

    public static function store($request) {
        $invoice = Invoice::getActiveInvoice();

        if ($invoice->items()->count()) {

            $vars = $request->except(['terms']);
            $vars['status'] = Invoice::PAID;

            $invoice->update($vars);

            BookingReport::store($invoice);

            $invoice->action = true;
            $invoice->message = 'You have successfully completed your transaction.';
            $invoice->redirectUrl = route('booking.index');
        }

        return $invoice;
    }
}
