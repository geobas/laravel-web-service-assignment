<?php

namespace App\Contracts\Repository;

use App\Models\Comment as CommentModel;
use App\Http\Resources\Comment as CommentResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Specify a set of repository methods for Comment retrieval & persistence.
 */
interface Comment
{
    /**
     * Get all Comments.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws App\Exceptions\CrudException
     */
    public function index(): AnonymousResourceCollection;

    /**
     * Save a new Comment.
     *
     * @return \App\Http\Resources\Comment
     *
     * @throws App\Exceptions\CrudException
     */
    public function store(): CommentResource;

    /**
     * Get one Comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \App\Http\Resources\Comment
     */
    public function show(CommentModel $comment): CommentResource;

    /**
     * Edit a Comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \App\Http\Resources\Comment
     *
     * @throws App\Exceptions\CrudException
     */
    public function update(CommentModel $comment): CommentResource;

    /**
     * Delete an Comment.
     *
     * @param  \App\Models\Comment  $comment
     * @return \App\Http\Resources\Comment
     *
     * @throws App\Exceptions\CrudException
     */
    public function destroy(CommentModel $comment): CommentResource;
}
