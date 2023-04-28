<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Table;
use App\Models\Invoice;
use App\Models\Sale;
use App\Traits\Barcode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use Barcode;
    public function payment(Request $request)
    {
        //checking if table exists
        $table = Table::find($request->table_id);
        if(!$table){
            return redirect()->back()->with('error', 'Table does not exist');
        }

        $paid = $request->paid ?? 0;
        $discount = $request->discount ?? 0;
        $customerName = $request->customer_name ?? 'Guest';
        $customerContact = $request->customer_contact ?? 'N/A';
        $tableNumber = $table->table_number;

        //getting all orders for the table
        $orders = Order::with(['recipe','user'])->where('table_id', $request->table_id)->get();

        //checking if table has orders
        if($orders->isEmpty()){
            return redirect()->back()->with('error', 'Table has no orders');
        }

        //calculating total price
        $total = $this->calculateTotalPrice($orders);

        //generating invoice
        $invoice = $this->generateInvoice($orders[0], $total, $paid, $discount, $customerName, $customerContact, $tableNumber);

        //convert orders to sales
        $sales = $this->convertOrdersToSales($orders, $invoice);

        //if sales are successfully created, delete orders
        $sales && Order::where('table_id', $request->table_id)->delete();

        //make the table available
        $table->status = 'free';
        $table->save();

        //return back with success message
        return response()->json([
            'message' => 'Payment successful',
            'tableId' => $request->table_id,
            'invoiceId' => $invoice->id,
        ]);
    }

    public function calculateTotalPrice($orders){

        $total = 0;
        foreach($orders as $order){
            $item_price = $order->recipe->price;
            $item_discount = $order->recipe->discount ?? 0;
            $item_price = $item_price - ($item_price * $item_discount / 100);
            $item_quantity = $order->quantity;
            $total += $item_price * $item_quantity;
        }

        return round($total);
    }

    public function generateInvoice($order, $total, $paid, $discount, $customerName, $customerContact, $tableNumber){
        $invoiceNumber = 0;
        do{
            $invoiceNumber = rand(10000000000, 99999999999);
            $invoiceNumber = $invoiceNumber.$this->calculateCheckDigit(strval($invoiceNumber));
        }while(Invoice::where('invoice_number', $invoiceNumber)->exists());

        $attendant = $order->user->name;

        $invoice = Invoice::create([
            'invoice_number' => $invoiceNumber,
            'username' => $attendant,
            'customer_name' => $customerName,
            'customer_contact' => $customerContact,
            'table_number' => $tableNumber,
            'total' => $total,
            'paid' => $paid,
            'discount' => $discount,
            'creator_name' => Auth::user()->name,
        ]);

        return $invoice;
    }

    public function convertOrdersToSales($orders, $invoice){

        foreach($orders as $order){
            $discount = $order->recipe->discount ?? 0;
            Sale::create([
                'invoice_id' => $invoice->id,
                'recipe_id' => $order->recipe_id,
                'recipe_name' => $order->recipe->recipe_name,
                'discount' => $order->recipe->discount ?? 0,
                'price' => $order->recipe->price,
                'quantity' => $order->quantity,
                'production_cost' => $order->recipe->production_cost,
                'username' => $order->user->name,
                'table_number' => $order->table->table_number,
            ]);
        }

        return true;
    }
}
