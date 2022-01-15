<?php

namespace App\Repositories;

use App\Exceptions\CrudException;
use App\Models\Comment as CommentModel;
use Illuminate\Database\QueryException;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Contracts\Repository\Comment as CommentRepositoryContract;

class Comment implements CommentRepositoryContract
{
    /**
     * Number of items that should displayed 'per page'.
     *
     * @var int
     */
    const ITEMS_PER_PAGE = 100;

    /**
     * Create a new repository instance.
     *
     * @param \App\Models\Comment  $model
     * @param \App\Http\Resources\Comment  $resource
     */
    public function __construct(
        protected CommentModel $model,
        protected CommentResource $resource,
    ) {
    }

    public function index(): AnonymousResourceCollection
    {
        try {
            return $this->resource->collection($this->model->simplePaginate(self::ITEMS_PER_PAGE));
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function store(): CommentResource
    {
        try {
            return $this->resource->make($this->model->create(request()->all()));
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function show(CommentModel $comment): CommentResource
    {
        return $this->resource->make($comment);
    }

    public function update(CommentModel $comment): CommentResource
    {
        try {
            return $this->resource->make(tap($comment)->update(request()->all()));
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }

    public function destroy(CommentModel $comment): CommentResource
    {
        try {
            return $this->resource->make(tap($comment)->delete());
        } catch (QueryException $e) {
            throw new CrudException($e->getMessage());
        }
    }
}
