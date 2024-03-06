<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Services\CarService;
use App\Services\ModelService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected string $model; //need to overwrite for sub-class

    protected Builder $query;
    protected string $resourceModel = ApiResource::class;

    protected ModelService $service;

    public function __construct()
    {
        $this->query = $this->model::query();
    }

    public function index()
    {
        $data = $this->query->get();
        return $this->resourceModel::collection($data);
    }

    public function show(mixed $id, int $status = Response::HTTP_OK): mixed
    {
        $model = (new $this->model());
        $result = $this->query->where($model->getTable() . '.' . $model->getKeyName(), $id)
            ->first();

        if (empty($result)) {
            throw new ModelNotFoundException();
        }

        $resource = new $this->resourceModel($result);
        return $resource->response()->setStatusCode($status);
    }

    public function store(Request $request): mixed
    {
        $validated = $request->validate($this->rules());

        try {
            $object = $this->model::create($validated);
        } catch (Throwable $e) {
            return response()->json(['message' => "Internal Error"], 500);
        }

        return $this->show($object->id, Response::HTTP_CREATED);
    }

    public function update(Request $request, mixed $id): mixed
    {
        $object = $this->query->findOrFail($id);
        $validated = $request->validate($this->rules());
        $object->fill($validated);
        if ($object->isDirty()) {
            $object->save();
        }
        return $this->show($id);
    }

    public function destroy(mixed $id)
    {
        try {
            $object = $this->query->findOrFail($id);

            if ($this->service->canDelete($object)) {
                $object->delete();
            } else {
                //TODO: should explicitly tell what is the reason
                return response()->json(['message' => "Unable to delete"], 422);
            }

            return response()->noContent();
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException();
        } catch (Throwable $e) {
            return response()->json(['message' => "Internal Error"], 500);
        }
    }

    protected function getModelTagName(): string
    {
        return class_basename($this->model);
    }

    protected abstract function rules();

}
