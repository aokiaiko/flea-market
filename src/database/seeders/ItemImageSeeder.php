<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemImage;
use App\Models\Item;

class ItemImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items =Item::all();

       $imagePaths = [
        'items/watch.jpg',
        'items/disc.jpg',
        'items/onion.jpg',
        'items/shoes.jpg',
        'items/pc.jpg',
        'items/microphon.jpg',
        'items/bag.jpg',
        'items/tumbler.jpg',
        'items/grinder.jpg',
        'items/cosmetics.jpg',
       ];

     foreach ($items as $index => $item) {
        ItemImage::create([
            'image_path' => $imagePaths[$index],
            'item_id' => $item->id,
        ]);
      }
    }
}
