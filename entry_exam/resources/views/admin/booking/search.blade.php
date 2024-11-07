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
        <h2 class="title">予約情報検索</h2>
        <hr>
        <div class="search-hotel-name">
            <form action="{{ route('adminBookingSearchResult') }}" method="post">
                @csrf
                <input type="text" name="customer_name" value="" placeholder="顧客名">
                <input type="number" name="customer_contact" value="" placeholder="顧客連絡先">
                <input type="date" name="checkin_time" value="" placeholder="チェックイン日時">
                <input type="date" name="checkout_time" value="" placeholder="チェックアウト日時">
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