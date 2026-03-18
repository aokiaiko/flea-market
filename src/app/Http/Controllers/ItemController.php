<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemImage;
use App\Models\Favorite;
use App\Models\Category;
use App\Models\Comment;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab'); 
        $keyword = $request->keyword;

        if ($tab === 'mylist' && !auth()->check()) {
            $items = collect();
            return view('items/index', compact('items', 'tab'));
        }
            
        if ($tab === 'mylist') { 
             $items = Item::with(['images','favorites','comments'])
            ->withCount(['favorites','comments'])
            ->whereHas('favorites', function ($query) {
                $query->where('user_id', auth()->id());
            });
            
            if (!empty($keyword)) {
                  $items->keywordSearch($keyword);
            }

            $items = $items->get();

        } else {
            
            //全商品表示
            $items = Item::with(['images','favorites','comments'])
            ->withCount(['favorites','comments']);

            if (auth()->check()) {
                 $items->where('user_id', '!=', auth()->id());
            }

            if (!empty($keyword)) {
                 $items->keywordSearch($keyword);
            }

            $items = $items->get();
        }
        
        return view('items/index',compact('items','tab'));
        
    }

    public function show($item_id)
    {
        $item = Item::with(['comments.user','images'])
            ->withCount(['favorites','comments'])
            ->findOrFail($item_id);
        $isFavorited = false;

        if (auth()->check()) {
        $isFavorited = Favorite::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->exists();
    }
        return view('items/show',compact('item','isFavorited'));
    }

    public function create()
    {
        return view('items/create');
    }

    public function store(ExhibitionRequest $request)
    {
        $item =Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'brand' => $request->brand,
            'description' => $request->description,
            'condition' => $request->condition,
            'status' => 0,
            'user_id' => auth()->id(),
        ]);

        $item->categories()->sync($request->category_ids);

        foreach ($request->file('images') as $file) {
            $path = $file->store('items', 'public');

          ItemImage::create([
                'item_id' => $item->id,
                'image_path' => $path,
          ]);
        
        }
        return redirect('/');

    }

    public function storeComment(CommentRequest $request, $item_id)
    {
         Comment::create([
                'user_id' => auth()->id(),
                'item_id' => $item_id,
                'comment' => $request->comment,
         ]);

         return redirect()->back();
    }



}


