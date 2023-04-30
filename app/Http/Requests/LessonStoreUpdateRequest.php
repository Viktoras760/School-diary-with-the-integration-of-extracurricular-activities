<?php

namespace App\Http\Requests;

use function auth;
use App\Models\Classroom;
use App\Traits\HasFailedValidation;
use Illuminate\Foundation\Http\FormRequest;

class LessonStoreUpdateRequest extends FormRequest
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
      'lessonName' => 'string|max:255',
      'lowerGradeLimit' => 'required|integer|max:12|min:0',
      'upperGradeLimit' => 'required|integer|max:12|min:0',
      'lessonsStartingTime' => 'required|date|date_format:Y-m-d H:i',
      'lessonsEndingTime' => 'required|date|after:lessonsStartingTime|date_format:Y-m-d H:i',
      'type' => 'integer',
      'fk_mainLessonsid_mainLessons' => 'nullable|integer',
      'fk_nonscholasticActivityid_nonscholasticActivity' => 'nullable|integer',
    ];
  }
}
