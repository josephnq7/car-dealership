<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

abstract class ApiController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected string $model; //need to overwrite for sub-class

    protected Builder $query;
    protected string $resourceModel = ApiResource::class;


    protected function setBasicQuery()
    {
        $this->query = $this->model::query();
    }

    public function index()
    {
        $this->setBasicQuery();

        $data = $this->query->paginate();
        return $this->resourceModel::collection($data);
    }

    public function show(mixed $id, int $status = Response::HTTP_OK): mixed
    {
        $this->setBasicQuery();
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
        $this->setBasicQuery();
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
            $this->setBasicQuery();

            $object = $this->query->findOrFail($id);

            $object->delete();

            return response()->noContent();
        } catch (ModelNotFoundException) {
            throw new ModelNotFoundException();
        } catch (Throwable $e) {
            return response()->json(['message' => "Internal Error"], 500);
        }
    }

    protected abstract function rules();

}
