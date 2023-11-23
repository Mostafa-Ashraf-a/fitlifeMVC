<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ApiResource extends JsonResource
{
    /**
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if (is_null($this->resource)) {
            return [];
        }
        if (is_array($this->resource)) {
            return $this->resource;
        }
        if (method_exists($this, 'transformer')) {
            return $this->transformer($request);
        }

        $id = $this->resource->id;
        $name = $this->resource->title;
        return array_merge($this->resource->toArray(), [
            "id"    => $id,
            "value" => $id,
            "key"   => (string) $id,
            "text"  => (string) $name,
        ]);
    }

    /**
     * @param  array  $merge
     *
     * @return array
     */
    protected function transformModel(array $merge = []): array
    {
        $model = $this->resource;
        $id = $model->id;
        $name = $model->title ? $model->name : null;

        return array_merge([
            "id"    => $id,
            "value" => $id,
            "key"   => (string) $id,
            "text"  => $name,
            "name"  => $name,
        ], Arr::except($model->only($model->getFillable()), $model->getHidden()), $merge);
    }
}
