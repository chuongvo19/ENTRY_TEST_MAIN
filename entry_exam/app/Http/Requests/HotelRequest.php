<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hotel_name' => 'required|max:255',
            'prefecture_id' => 'required|integer',
            'file_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'hotel_name.required' => 'ホテルの名前を入力してください',
            'hotel_name.max:255' => 'ホテルの名前は255文字を超えてはいけません ',
            'prefecture_id.required' => 'ホテルの位置を選択してください ',
            'prefecture_id.integer' => 'ホテルの位置を選択してください ',
            'file_path.image' => '画像ファイルのみ受け付けます',
            'file_path.mimes:jpeg,png,jpg,gif' => 'JPEG、PNG、JPG形式のファイルをアップロードしてください',
            'file_path.max:2048' => '2MB未満の画像をアップロードしてください'
        ];
    }
}
