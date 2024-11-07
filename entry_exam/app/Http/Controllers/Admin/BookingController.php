<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function showSearch()
    {
        return view('admin.booking.search');
    }

    public function searchResult(Request $request)
    {
        $var = [];
        $customerName = $request->input('customer_name');
        $customerContact = $request->input('customer_contact');
        $checkinTime = $request->input('checkin_time');
        $checkoutTime = $request->input('checkout_time');
        // dd($checkinTime);
        $checkSearchResult = 0;
        $colection = Booking::query();
        if ($customerName) {
            $colection->where('customer_name', 'like', '%' . $customerName . '%');
            $checkSearchResult++;
        }

        if ($customerContact) {
            $colection->where('customer_contact', '=', substr($customerContact, 1));
            $checkSearchResult++;
        }

        if ($checkinTime) {
            $colection->whereDate('checkin_time', '=', Carbon::parse($checkinTime)->toDateString());
            $checkSearchResult++;
        }

        if ($checkoutTime) {
            $colection->whereDate('checkout_time', '=', Carbon::parse($checkoutTime)->toDateString());
            $checkSearchResult++;
        }
        $bookings = ($checkSearchResult == 0) ? [] : $colection->get()->toArray();
        $var['bookings'] = $bookings;
        return view('admin.booking.result', $var);
    }
}
