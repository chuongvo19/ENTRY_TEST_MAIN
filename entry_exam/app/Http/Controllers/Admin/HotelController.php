<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;
use Illuminate\Http\RedirectResponse;
use PhpParser\Node\Scalar\MagicConst\Dir;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        return view('admin.hotel.search');
    }

    public function showResult(): View
    {
        return view('admin.hotel.result');
    }

    public function showEdit(Request $request): View
    {
        $listPrefecture = Prefecture::all();
        $hotelInfo = Hotel::findOrFail($request->input('hotel_id'));
        return view('admin.hotel.edit', compact(
                'listPrefecture',
                'hotelInfo'
            )
        );
    }

    public function showCreate(): View
    {
        $listPrefecture = Prefecture::all();

        return view('admin.hotel.create', compact('listPrefecture'));
    }

    /** post methods */

    public function searchResult(Request $request): View
    {
        $var = [];

        $hotelNameToSearch = $request->input('hotel_name');
        $hotelList = Hotel::getHotelListByName($hotelNameToSearch);

        $var['hotelList'] = $hotelList;

        return view('admin.hotel.result', $var);
    }

    public function edit(HotelRequest $request): RedirectResponse
    {
        $validateData = $request->validated();
        $hotel = Hotel::findOrFail($request->input('hotel_id'));
        $hotel->hotel_name = $request->input('hotel_name');
        $hotel->prefecture_id = $request->input('prefecture_id');

        if($request->hasFile('file_path'))
        {
            $oldImagePath = $hotel->file_path;

            $image = $request->file('file_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img/hotel'), $imageName);
            $hotel->file_path = 'hotel' . DIRECTORY_SEPARATOR . $imageName;
        }

        try {
            $hotel->save();
            if(
                isset($oldImagePath) &&
                file_exists(public_path('assets/img') .DIRECTORY_SEPARATOR . $oldImagePath)
            ) 
            {
                unlink(public_path('assets/img') .DIRECTORY_SEPARATOR . $oldImagePath);
            }
            return redirect()->back()->with('success', 'ホテル情報の編集が成功しました ');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('error', 'ホテル情報の編集に失敗しました');
        }
    }

    public function create(HotelRequest $request): RedirectResponse
    {
        $validateData = $request->validated();

        if($request->hasFile('file_path'))
        {
            $image = $request->file('file_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img/hotel'), $imageName);
        } else {
            $imageName = 'default_image.jpg';
        }

        try {
            Hotel::create([
                'hotel_name' => $request->hotel_name,
                'prefecture_id' => $request->prefecture_id,
                'file_path' => 'hotel' . DIRECTORY_SEPARATOR . $imageName
            ]);

            return redirect()->route('adminHotelCreatePage')->with('success', 'ホテルの初期化成功 ');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'ホテルの初期化失敗 ');
        }
    }

    public function delete(Request $request): void
    {
        //
    }
}
