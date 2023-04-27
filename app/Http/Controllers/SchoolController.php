<?php

namespace App\Http\Controllers;

use App\Http\Requests\SchoolStoreUpdateRequest;
use App\Models\School;
use App\Services\SchoolService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class SchoolController extends Controller
{
    private SchoolService $schoolService;
    public function __construct(SchoolService $schoolService)
    {
      $this->schoolService = $schoolService;
      $this->middleware('auth:api', ['except' => ['index']]);
    }
    public function update($id, SchoolStoreUpdateRequest $request): JsonResponse
    {
      $data = $request->validated();

      $handler = $this->schoolService->schoolErrorHandler($id);

      if (!$handler)
      {
        try {
          if (!$this->schoolService->update($id, $data)) {
            return response()->json(['message' => trans('global.update_failed')], 422);
          }
          return response()->json(['success' => 'School updated successfully']);
        } catch (QueryException $e) {
          return response()->json(['error' => $e->getMessage(), 'message' => trans('global.update_failed')], 422);
        }
      }
      else return $handler;
    }

    function show($schoolId)
    {
      $handler = $this->schoolService->schoolErrorHandler($schoolId);

      $school = School::find($schoolId);

      if (!$handler) {
        return $school;
      } else {
        return $handler;
      }
    }

    function index(): Collection|JsonResponse
    {

      $handler = $this->schoolService->schoolsErrorHandler('get');

      $schools = School::all();

      if (!$handler) {
        return $schools;
      } else {
        return $handler;
      }
    }

    function store(SchoolStoreUpdateRequest $req): JsonResponse|School
    {
      $data = $req->validated();

      try {
        $handle = $this->schoolService->schoolsErrorHandler('add');
        $exists = $this->schoolService->schoolExistance($data);

        if (!$handle && !$exists) {
          return $this->schoolService->create($data);
        } else {
          return $handle ?: $exists;
        }
      } catch (QueryException $e) {
        return response()->json(['error' => $e->getMessage(), 'message' => trans('global.create_failed')], 422);
      }
    }

    function destroy($id): JsonResponse
    {
      try {
        $school = School::find($id);

        $handle = $this->schoolService->schoolDeletionErrorHandler($id);

        if (!$handle) {
          $school->delete();

          return response()->json(['success' => 'School deleted']);

        } else {
          return $handle;
        }
      } catch (QueryException $e) {
        return response()->json(['error' => $e->getMessage(), 'message' => trans('global.delete_failed')], 422);
      }

    }
}
