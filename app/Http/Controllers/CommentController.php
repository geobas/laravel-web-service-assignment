<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Helpers\HttpStatus as Status;
use App\Http\Requests\Comment as CommentRequest;
use App\Contracts\Repository\Comment as CommentRepositoryContract;

/**
 * Controller to handle all requests regarding Comments.
 */
class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param \App\Contracts\Repository\Comment  $repository
     */
    public function __construct(
        protected CommentRepositoryContract $repository,
    ) {
    }

    /**
     * Display a listing of the resource.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \Illuminate\Http\Request;
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            return response()->api(
                $this->repository->index()->resource,
                Status::OK
            );
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Http\Requests\Comment  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentRequest $request)
    {
        try {
            return response()->api([
                'data' => $this->repository->store(),
            ], Status::CREATED);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);
        }
    }

    /**
     * Display the specified resource.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Comment $comment)
    {
        try {
            return response()->api([
                'data' => $this->repository->show($comment),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Http\Requests\Comment  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        try {
            return response()->api([
                'data' => $this->repository->update($comment),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Comment $comment)
    {
        try {
            return response()->api([
                'data' => $this->repository->destroy($comment),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logError($t);
        }
    }
}
