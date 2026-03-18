<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Purchase;


class MypageController extends Controller
{
    public function edit()
  {
    $user = auth()->user(); 
    $address = $user->addresses()->latest()->first();
    return view('mypage/edit',compact('user','address'));
  }

   public function show(Request $request)
  {
    $page =$request->page;

    $user = auth()->user();

    $sellItems = Item::where('user_id', auth()->id())
        ->with('images')    
        ->get();

    $buyItems = Purchase::where('user_id', auth()->id())
        ->with('item.images') 
        ->get();
    return view('mypage/show',compact('page','sellItems', 'buyItems','user'));
  }

  public function update(ProfileRequest $request)
  {
    $user=auth()->user();

    $user->update($request->safe()->except(['profile_image']));

     $data = $request->only(['postcode','address','building']);

    if ($request->filled('postcode') && $request->filled('address')) {
        $address = $user->addresses()->first();
        $address ? $address->update($data) : $user->addresses()->create($data);
    }

    if ($request->hasFile('profile_image')) {
       $path = $request->file('profile_image')->store('profiles', 'public');
       $user->update(['profile_image' => $path]);
    }

    return redirect('/?tab=mylist');
    
  }
}

