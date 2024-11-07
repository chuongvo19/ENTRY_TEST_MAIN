<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Http\Requests\SearchRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Hotel;
use App\Models\Prefecture;
use Illuminate\Http\RedirectResponse;

class HotelController extends Controller
{
    /** get methods */

    public function showSearch(): View
    {
        $listPrefecture = Prefecture::all();
        return view('admin.hotel.search', compact('listPrefecture'));
    }

    public function showResult(): View
    {
        $listPrefecture = Prefecture::all();
        return view('admin.hotel.result', compact('listPrefecture'));
    }

    public function showEdit(Request $request): View
    {
        $listPrefecture = Prefecture::all();
        $hotelInfo = Hotel::findOrFail($request->input('hotel_id'));
        return view(
            'admin.hotel.edit',
            compact(
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

    public function cancelEdit(Request $request): RedirectResponse
    {
        $hotelId = $request->input('hotel_id');
        if (
            !empty($request->input('file_path')) &&
            file_exists(public_path('assets/img') . DIRECTORY_SEPARATOR . $request->input('file_path')) &&
            $request->input('file_path') != 'hotel/default_image.jpg'
        ) {
            unlink(public_path('assets/img') . DIRECTORY_SEPARATOR . $request->input('file_path'));
        }
        return redirect()->route('adminHotelEditPage', ['hotel_id' => $hotelId]);
    }

    /** post methods */


    public function confirm(HotelRequest $request): View
    {
        $validateData = $request->validated();
        $isUploadImage = false;
        if ($request->hasFile('file_path')) {
            $isUploadImage = true;
            $image = $request->file('file_path');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/img/hotel'), $imageName);
        } else {
            $imageName = Hotel::select('file_path')->where('hotel_id', $request->input('hotel_id'))->value('file_path');
        }

        $prefecture = Prefecture::select('prefecture_name')
            ->where('prefecture_id', $request->input('prefecture_id'))
            ->value('prefecture_name');

        $dataConfirm = [
            'hotel_id' => $request->input('hotel_id'),
            'hotel_name' => $request->input('hotel_name'),
            'prefecture' => [
                'id' => $request->input('prefecture_id'),
                'name' => $prefecture
            ],
            'file_path' => [
                'is-upload-image' => $isUploadImage,
                'path' => ($isUploadImage) ? 'hotel' . DIRECTORY_SEPARATOR . $imageName : $imageName
            ]
        ];

        return view('admin.hotel.confirm', compact('dataConfirm'));
    }

    public function searchResult(SearchRequest $request): View
    {
        $request->validated();
        $var = [];

        $hotelNameToSearch = $request->input('hotel_name');
        $hotelPrefectureId = $request->input('prefecture_id');
        if(empty($hotelPrefectureId))
        {
            $hotelList = Hotel::getHotelListByName($hotelNameToSearch);
        } else {
            $hotelList = Hotel::getHotelListByNameAndPrefectureId($hotelNameToSearch, $hotelPrefectureId);
        }
        $var['hotelList'] = $hotelList;
        $var['listPrefecture'] = Prefecture::all();

        return view('admin.hotel.result', $var);
    }

    public function edit(Request $request): RedirectResponse
    {
        $hotel_id = $request->input('hotel_id');
        $hotel = Hotel::findOrFail($hotel_id);

        try {
            $oldPath = Hotel::getPathImageWithId($hotel_id);
            if (
                !empty($request->input('file_path')) &&
                file_exists(public_path('assets/img') . DIRECTORY_SEPARATOR . $oldPath) &&
                $oldPath != 'hotel/default_image.jpg'
            ) {
                unlink(public_path('assets/img') . DIRECTORY_SEPARATOR . $oldPath);
            }
            $hotel->update($request->all());

            return redirect()->route('adminHotelEditPage', ['hotel_id' => $hotel_id])->with('success', '情報の編集が成功しました');
        } catch (\Exception $e) {
            return redirect()->route('adminHotelEditPage', ['hotel_id' => $hotel_id])->with('error', '情報の編集に失敗しました');
        }
    }

    public function create(HotelRequest $request): RedirectResponse
    {
        $validateData = $request->validated();

        if ($request->hasFile('file_path')) {
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

    public function delete(Request $request): RedirectResponse
    {
        $hotel_id = $request->input('hotel_id');
        try {
            $filePath = Hotel::getPathImageWithId($hotel_id);
            Hotel::destroy($hotel_id);
            if (
                file_exists(public_path('assets/img') . DIRECTORY_SEPARATOR . $filePath) &&
                $filePath != 'hotel/default_image.jpg'
            ) {
                unlink(public_path('assets/img') . DIRECTORY_SEPARATOR . $filePath);
            }
            return redirect()->route('adminHotelSearchPage')->with('success', '情報の削除が成功しました');
        } catch (\Exception $e) {
            return redirect()->route('adminHotelSearchPage')->with('success', '情報の削除に失敗しました');
        }
    }
}
