<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Invoice;
use App\InvoiceItem;

class InvoiceFetchController extends Controller
{
    public function fetch()
    {
        $invoice = Invoice::getActiveInvoice();
        $ids = $invoice->items()->pluck('id');

        $items = InvoiceItem::whereIn('id', $ids)->with(['location', 'category', 'type', 'time'])->get();

        return response()->json([
            'invoice' => $invoice,
            'items' => $items,
        ]);
    }
}
