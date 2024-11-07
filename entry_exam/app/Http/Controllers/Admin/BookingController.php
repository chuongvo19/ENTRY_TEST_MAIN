<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function showSearch() {
        return view('admin.booking.search');
    }

    public function searchResult(Request $request)
    {
        dd($request->all());
    }
}
