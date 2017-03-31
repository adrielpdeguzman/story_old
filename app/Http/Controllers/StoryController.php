<?php

namespace App\Http\Controllers;

use App\User;
use App\Story;
use App\StoryFilters;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(User $user, StoryFilters $filters)
    {
        if (request()->exists('withPartner')) {
            $stories = Story::whereIn('user_id', [$user->id, $user->partner->id]);
        } else {
            $stories = $user->stories();
        }

        $stories->filter($filters);

        if (request('page')) {
            $stories = $stories->paginate(request('per_page'));
        } else {
            $stories = $stories->get();
        }

        return response()->json($stories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, User $user)
    {
        $this->validate($request, [
            'publish_date' => 'required|date_format:Y-m-d|unique:stories,publish_date,user_id'.$user->id,
            'title' => 'required',
            'plot' => 'required',
            'synopsis' => 'present',
        ]);

        $story = new Story;
        $story->fill($request->only([
            'publish_date', 'title', 'plot', 'synopsis',
        ]));
        $story->season = season($request->publish_date, $user->anniversary_date);
        $story->episode = episode($request->publish_date, $user->anniversary_date);
        $story->user()->associate($user);
        $story->save();

        return response()->json($story, 201)
            ->header('Location', route('users.stories.show', [
                'user' => $user, 'id' => $story->id,
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @param  \App\Story  $story
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user, Story $story)
    {
        return response()->json($story);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @param  \App\Story  $story
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user, Story $story)
    {
        $this->validate($request, [
            'title' => 'sometimes|required',
            'plot' => 'sometimes|required',
            'synopsis' => 'sometimes|present',
        ]);

        $story->fill($request->intersect([
            'title', 'plot', 'synopsis',
        ]));
        $story->save();

        return response()->json($story);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @param  \App\Story  $story
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, Story $story)
    {
        return response()->json($story->delete(), 204);
    }
}
