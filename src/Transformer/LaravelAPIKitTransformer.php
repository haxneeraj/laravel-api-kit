<?php

// Author: Neeraj Saini
// Email: hax-neeraj@outlook.com
// GitHub: https://github.com/haxneeraj/
// LinkedIn: https://www.linkedin.com/in/hax-neeraj/

namespace Haxneeraj\LaravelAPIKit\Transformer;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

use Haxneeraj\LaravelAPIKit\Exceptions\ApiException;

abstract class LaravelAPIKitTransformer
{
    /**
     * Abstract function that must be implemented by child classes
     * to transform a single model instance.
     *
     * @param Model $model
     * @return array
     */
    abstract public function model($model);

    /**
     * Transform the given data based on its type.
     *
     * @param mixed $model
     * @return array
     */
    public function transform($model)
    {
        // Check if the input is an instance of a Model and transform it.
        if ($model instanceof Model) {
            return $this->model($model);
        }
        // Check if the input is an Eloquent Collection and map over it.
        elseif ($model instanceof EloquentCollection) {
            return $model->map(function ($item) {
                return $this->model($item);
            })->all();
        }
        // Handle LengthAwarePaginator or Paginator instances.
        elseif ($model instanceof LengthAwarePaginator || $model instanceof Paginator) {
            $transformedItems = $model->getCollection()->map(function ($item) {
                return $this->model($item);
            })->all();

            // Pagination details
            $pages = [];
            for ($page = 1; $page <= $model->lastPage(); $page++) {
                $pages[] = [
                    'url' => $model->url($page),
                    'label' => $page,
                    'active' => $page == $model->currentPage(),
                ];
            }

            return [
                'items' => $transformedItems,
                'total_items' => $model->total(),
                'current_page' => $model->currentPage(),
                'per_page' => $model->perPage(),
                'last_page' => $model->lastPage(),
                'links' => [
                    'first' => $model->url(1),
                    'prev' => $model->previousPageUrl(),
                    'pages' => $pages,
                    'next' => $model->nextPageUrl(),
                    'last' => $model->url($model->lastPage()),
                ],
            ];
        }
        // Throw an exception if the input type is not supported.
        else {
            if(!request()->expectsJson())
            {
                // Create a ValidationException instance
                $exception = new \RuntimeException('Expected instance of ' . Model::class . ' or ' . EloquentCollection::class);

                // Generate a custom API error response using ApiException
                return ApiException::handleException($exception);
            }
            throw new \RuntimeException('Expected instance of ' . Model::class . ' or ' . EloquentCollection::class);
        }
    }
}
