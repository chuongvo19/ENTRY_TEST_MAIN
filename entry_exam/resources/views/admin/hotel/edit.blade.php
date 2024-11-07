<!-- base view -->
@extends('common.admin.base')

@section('custom_css')
    @vite('resources/scss/admin/create.scss')
@endsection

@section('main_contents')
    <div class="page-wrapper">
        <h2 class="title">ホテル情報の編集</h2>
        <hr>
        <div class="form-post-wrapper">
            <x-alert />
            <form action="{{ route('adminHotelConfirmProcess') }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="hotel_id" value="{{ $hotelInfo->hotel_id }}" />
                <table class="table-border-none">
                    <tbody>
                        {{-- name hotel --}}
                        <tr>
                            <td>
                                <label for="hotel_name">名前 </label>
                            </td>
                            <td>
                                <input type="text" id="hotel_name" name="hotel_name" placeholder=""
                                    value="{{ old('hotel_name', $hotelInfo->hotel_name) }}">
                                @error('hotel_name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        {{-- prefecture --}}
                        <tr>
                            <td>
                                <label for="preteturies">県</label>
                            </td>
                            <td>
                                <input type="hidden" placeholder="">
                                <select name="prefecture_id" id="preteturies">
                                    <option value="">---</option>
                                    @foreach ($listPrefecture as $prefecture)
                                        <option value="{{ $prefecture->prefecture_id }}"
                                            {{ old('prefecture_id', $hotelInfo->prefecture_id) == $prefecture->prefecture_id ? 'selected' : '' }}>
                                            {{ $prefecture->prefecture_name }}</option>
                                    @endforeach
                                </select>
                                @error('prefecture_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <img style="width: 33.33%; height: auto;" src="/assets/img/{{ $hotelInfo->file_path }}"
                                    alt="{{ $hotelInfo->hotel_name }}">
                            </td>
                        </tr>
                        {{-- image hotel --}}
                        <tr>
                            <td>
                                <label for="file_path">ホテルの画像</label>
                            </td>
                            <td>
                                <input type="file" id="file_path" name="file_path" placeholder="">
                                @error('file_path')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <button type="submit">送信</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection
