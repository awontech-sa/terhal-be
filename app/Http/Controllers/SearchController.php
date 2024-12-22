<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Product;
use App\Models\Tour;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Request $request)
    {
        $search = $request->input('search');
        $tour = Tour::where('t_name', 'like', '%' . $search . '%')->get();
        $products = Product::where('pr_name', 'like', '%' . $search . '%')->get();
        $events = Event::where('e_name', 'like', '%' . $search . '%')->get();

        $result = collect();

        if ($tour->isNotEmpty()) {
            $result = $result->merge($tour);
        }
        
        if ($products->isNotEmpty()) {
            $result = $result->merge($products);
        }
        
        if ($events->isNotEmpty()) {
            $result = $result->merge($events);
        }
        return $result;
    }
}
