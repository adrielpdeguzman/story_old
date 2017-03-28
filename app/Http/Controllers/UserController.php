<?php

namespace App\Http\Controllers;

use Hash;
use App\User;
use App\GenericFilters;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\GenericFilters  $filters
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(GenericFilters $filters)
    {
        $users = User::filter($filters);

        if (request('page')) {
            $users = $users->paginate(request('per_page'));
        } else {
            $users = $users->get();
        }

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
            'name' => 'required',
        ]);

        $user = new User;
        $user->fill($request->only([
            'email', 'name'
        ]));
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json($user, 201)
            ->header('Location', route('users.show', ['id' => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|confirmed|min:6',
            'name' => 'sometimes|required',
        ]);

        $user->fill($request->intersect([
            'email', 'name'
        ]));

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        return response()->json($user->delete(), 204);
    }
}
