<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store($item_id)
    {
    $item = Item::findOrFail($item_id);

    Favorite::firstOrCreate([
            'user_id' => Auth::id(),
            'item_id' => $item->id,
        ]);

        return redirect()->back();
    }

    public function destroy($item_id)
    {
        $item = Item::findOrFail($item_id);

        Favorite::where('user_id', Auth::id())
                ->where('item_id', $item->id)
                ->delete();

        return redirect()->back();
    }
}
