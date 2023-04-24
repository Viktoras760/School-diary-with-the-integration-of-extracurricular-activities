<?php

namespace App\Http\Requests;

use function auth;
use App\Models\School;
use Illuminate\Validation\Rule;
use App\Traits\HasFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class SchoolStoreUpdateRequest extends FormRequest
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
      'address' => 'required|string|max:255',
      'pupilAmount' => 'required|integer|max:5000|min:0',
      'teacherAmount' => 'required|integer|max:1000|min:0',
    ];
  }
}
