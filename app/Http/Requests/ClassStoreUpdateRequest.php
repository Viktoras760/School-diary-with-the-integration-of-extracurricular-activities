<?php

namespace App\Http\Requests;

use function auth;
use App\Models\Classroom;
use App\Traits\HasFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class ClassStoreUpdateRequest extends FormRequest
{
  use HasFailedValidation;
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return auth()->check();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'name' => 'required|string|max:255',
      'grade' => 'required|integer|min:1|max:12',
      'classTeacherId' => 'required|integer',
    ];
  }
}
