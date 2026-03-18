<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use App\Models\Address;


class AddressController extends Controller
{
   public function edit($item_id)
   {
     $address = auth()->user()->addresses()->latest()->first();

     return view('addresses/edit',compact('item_id','address'));
   }

   public function update(AddressRequest $request, $item_id)
   {
     $user = auth()->user();

    if ($user->addresses()->exists()) {
        $user->addresses()->latest()->first()->update($request->validated());
    } else {
        $user->addresses()->create($request->validated());
    }

      return redirect("/purchase/{$item_id}");
   }
}

