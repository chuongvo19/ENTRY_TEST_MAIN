<!-- base view -->
@extends('common.admin.base')

<!-- CSS per page -->
@section('custom_css')
    @vite('resources/scss/admin/search.scss')
    @vite('resources/scss/admin/result.scss')
@endsection

<!-- main containts -->
@section('main_contents')
    <div class="page-wrapper search-page-wrapper">
        <h2 class="title">検索画面</h2>
        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('adminHotelSearchResult') }}" method="post">
                @csrf
                <input type="text" name="hotel_name" value="" placeholder="ホテル名">
                <select name="prefecture_id" id="preteturies">
                    <option value="">--Prefecture--</option>
                    @foreach ($listPrefecture as $prefecture)
                        <option value="{{ $prefecture->prefecture_id }}"
                            {{ old('prefecture_id') == $prefecture->prefecture_id ? 'selected' : '' }}>
                            {{ $prefecture->prefecture_name }}</option>
                    @endforeach
                </select>
                <button type="submit">検索</button>
            </form>
            @error('hotel_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <hr>
        <div class="aler-message">
            <x-alert />
        </div>
    </div>
    @yield('search_results')
@endsection