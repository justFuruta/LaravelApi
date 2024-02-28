<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentStoreRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CommentResource::collection(Comment::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentStoreRequest $request)
    {
        try {
            $comment = Comment::create($request->validated());
            return response()->json(['message' => 'Комментарий успешно создан', 'data' => new CommentResource($comment)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка создания комментария: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentStoreRequest $request, Comment $comment)
    {
        try {
            $comment->update($request->validated());
            return response()->json(['message' => 'Данные комментария успешно обновлены', 'data' => new CommentResource($comment)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка обновления данных комментария: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();

            return response()->json(['message' => 'Комментарий успешно удален'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка удаления комментария: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
