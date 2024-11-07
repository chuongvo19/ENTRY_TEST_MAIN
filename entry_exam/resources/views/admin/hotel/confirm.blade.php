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
            <table class="table-border-none">
                <tbody>
                    {{-- name hotel --}}
                    <tr>
                        <td>
                            <label for="hotel_name">名前 </label>
                        </td>
                        <td>
                            <p>{{ $dataConfirm['hotel_name'] }}</p>
                        </td>
                    </tr>
                    {{-- prefecture --}}
                    <tr>
                        <td>
                            <label for="preteturies">県</label>
                        </td>
                        <td>
                            <p>{{ $dataConfirm['prefecture']['name'] }}</p>
                        </td>
                    </tr>
                    {{-- image hotel --}}
                    <tr>
                        <td>
                            <label for="file_path">ホテルの画像</label>
                        </td>
                        <td>
                            <img style="width: 33.33%; height: auto;"
                                src="/assets/img/{{ $dataConfirm['file_path']['path'] }}"
                                alt="{{ $dataConfirm['file_path']['path'] }}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <form action="{{ route('adminHotelEditProcess') }}" method="post">
                                @csrf
                                <input type="hidden" name="hotel_id" value="{{ $dataConfirm['hotel_id'] }}" />
                                <input type="hidden" name='hotel_name' value="{{ $dataConfirm['hotel_name'] }}" />
                                <input type="hidden" name="prefecture_id" value="{{ $dataConfirm['prefecture']['id'] }}" />
                                @if ($dataConfirm['file_path']['is-upload-image'])
                                    <input type="hidden" name="file_path" value="{{ $dataConfirm['file_path']['path'] }}" />
                                @endif
                                <button id="btn-submit" type="submit">確認</button>
                            </form>
                        </td>
                        <td>
                            <form action=" {{ route('adminHotelCancelProcess') }}" method="get">
                                <input type="hidden" name="hotel_id" value="{{ $dataConfirm['hotel_id'] }}">
                                @if ($dataConfirm['file_path']['is-upload-image'])
                                    <input type="hidden" name="file_path" value="{{ $dataConfirm['file_path']['path'] }}" />
                                @endif
                                <button id="btn-back" type="submit">キャンセル</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
