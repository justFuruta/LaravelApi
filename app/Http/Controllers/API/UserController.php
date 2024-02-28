<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserStoreRequest $request)
    {
        try {
            $data = $request->validated();

            $avatar = $request->file('avatar');
            $avatarName = uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'avatar' => $avatarPath
            ]);

            return response()->json(['message' => 'Пользователь успешно создан', 'data' => new UserResource($user)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка создания пользователя: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserStoreRequest $request, User $user)
    {

        try {
            $data = $request->validated();

            $avatar = $request->file('avatar');
            $avatarName = uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = $avatar->storeAs('avatars', $avatarName, 'public');
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $avatarPath;
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->phone_number = $data['phone_number'];
            $user->save();

            return response()->json(['message' => 'Данные пользователя успешно обновлены', 'data' => new UserResource($user)], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка обновления данных пользователя: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Пользователь успешно удален'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка удаления пользователя: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
