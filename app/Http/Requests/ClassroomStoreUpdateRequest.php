<?php

namespace App\Http\Requests;

use function auth;
use App\Models\Classroom;
use App\Traits\HasFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class ClassroomStoreUpdateRequest extends FormRequest
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
      'number' => 'required|integer|max:999|min:1',
      'floorNumber' => 'required|integer|max:20|min:1',
      'pupilCapacity' => 'required|integer|max:99|min:1',
      'musicalEquipment' => 'required|in:1,2',
      'chemistryEquipment' => 'required|in:1,2',
      'computers' => 'required|in:1,2'
    ];
  }
}
