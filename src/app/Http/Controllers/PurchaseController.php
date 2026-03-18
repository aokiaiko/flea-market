<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Purchase;
use App\Models\Address;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;



class PurchaseController extends Controller
{
        public function create($item_id)
    {
        $item = Item::with('images')->findOrFail($item_id);
        $address = auth()->user()->addresses()->latest()->first();


        return view('items/purchase',compact('item','address'));
    }

        public function store(PurchaseRequest $request,$item_id)
    {
        $item = Item::findOrFail($item_id);

        Purchase::create([
            'user_id'   =>auth()->id(),
            'item_id'   =>$item_id,
            'address_id'=>$request->address_id, 
            'price'     => $item->price,
            'status'    => 1,  
            'payment_method'=> $request->payment_method,
        ]);

        Item::where('id', $item_id)->update(['status' => Item::STATUS_SOLD]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

         $paymentMethodTypes = $request->payment_method === 'konbini'
          ? ['konbini']
          : ['card'];

         $session = CheckoutSession::create([
          'mode' => 'payment',
          'payment_method_types' => $paymentMethodTypes, 

          'line_items' => [[
            'quantity' => 1,
            'price_data' => [
                'currency' => 'jpy',
                'unit_amount' => (int) $item->price,
                'product_data' => [
                    'name' => $item->name,
                ],
            ],
          ]],

          'success_url' => url('/'),
          'cancel_url'  => url("/purchase/{$item_id}"),


          
         ]);

          return redirect()->away($session->url);


    }
}
