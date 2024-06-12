<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use App\Models\Mobile;

class PurchaseController extends Controller
{
    public function purchase()
    {
        $purchases = Purchase::paginate(10); 
        return view('purchase', compact('purchases'));
    }

    public function yourorder()
    {
        $orders = Purchase::where('user_id', auth()->id())->get();

        return view('yourorder', compact('orders'));
    }

    
}
