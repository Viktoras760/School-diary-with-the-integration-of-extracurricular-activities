<?php

namespace App\Http\Requests;

use function auth;
use App\Traits\HasFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
  use HasFailedValidation;
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize(): bool
  {
    return auth()->check();
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules(): array
  {
    return [
      'name' => 'required|string|max:50|min:2',
      'surname' => 'required|string|max:100|min:2',
      'personalCode' => 'required|integer|digits_between:9,15',
      'email' => 'required|email',
      'grade' => 'required|integer|min:0|max:12',
      'fk_Schoolid_School' => 'required',
      'role' => 'required',
      'confirmation' => 'required',
      'speciality' => 'string'

    ];
  }
}
