<?php

namespace App\Http\Controllers;

use Log;
use Throwable;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function index(Request $request): JsonResponse|bool
    {
        try {
            return response()->api(
                $this->repository->index()->resource,
                Status::OK
            );
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);

            return true;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Http\Requests\Comment  $request
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function store(CommentRequest $request): JsonResponse|bool
    {
        try {
            return response()->api([
                'data' => $this->repository->store(),
            ], Status::CREATED);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);

            return true;
        }
    }

    /**
     * Display the specified resource.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function show(Comment $comment): JsonResponse|bool
    {
        try {
            return response()->api([
                'data' => $this->repository->show($comment),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);

            return true;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Http\Requests\Comment  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function update(CommentRequest $request, Comment $comment): JsonResponse|bool
    {
        try {
            return response()->api([
                'data' => $this->repository->update($comment),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);

            return true;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @uses   \App\Providers\ResponseServiceProvider
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\JsonResponse|bool
     */
    public function destroy(Comment $comment): JsonResponse|bool
    {
        try {
            return response()->api([
                'data' => $this->repository->destroy($comment),
            ], Status::OK);
        } catch (Throwable $t) {
            $this->logErrorAndThrow($t);

            return true;
        }
    }

    /**
     * Log error.
     *
     * @param  Throwable  $t
     * @return void
     *
     * @throws \Exception|\Error
     */
    protected function logErrorAndThrow(Throwable $t): void
    {
        Log::error("'" . $t->getMessage() . "' - File: '" . $t->getFile() . "' - Method: '"
            . debug_backtrace()[1]['function'] . "' at line: " . $t->getLine());

        throw $t;
    }
}
