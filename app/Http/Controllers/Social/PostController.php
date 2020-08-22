<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Post;
use App\r;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $user;

    // TODO Implement overturn package

    public function __construct(UserService $user) {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->loggedInUser();
        $posts = Post::where('user_id', $user->id)->orderBy('created_at')->get();

        return response()->json([
            "data" => [
                "posts" => $posts
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loggedInUser = $this->user->loggedInUser();
        $validatedData = $request->validate([
                            'description' => 'sometimes|required|max:1000',
                            'photo' => 'sometimes|required|image:jpeg, jpg, png|max:2000',
                        ]);

        if ($request->hasFile('photo')) {
            $extension = $request->photo->extension();
            $name = Str::random(15).".".$extension;

            $file = $request->photo->storeAs('posts/images', $name, 'public');
        }

        if($validatedData) {

            $post = Post::create([
                'user_id' => $loggedInUser->id,
                'content' => $request->description,
                'image' => $name,
            ]);
            return response()->json([
                $post
            ], 200);
        }

        return response()->json([
            "root" => [
                "error" => "Something went wrong please try again"
            ]
        ], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function show(r $r)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->loggedInUser();
        $post = Post::where('id',$id)->get();

        return response()->json([
            "data" => [
                "post" => $post
            ]
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\r  $r
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'description' => 'sometimes|required|max:1000',
            'photo' => 'sometimes|required|image:jpeg, jpg, png|max:2000',
        ]);

        if ($request->hasFile('photo')) {
            $extension = $request->photo->extension();
            $name = Str::random(15).".".$extension;

            $file = $request->photo->storeAs('posts/images', $name, 'public');
        }

        if($validatedData) {

            $post = Post::where('id', $id)->update([
                'content' => $request->description,
                'image' => $name,
                'is_modified' => true,
            ]);

            return response()->json(
                true, 201);
        }

        return response()->json([
            "root" => [
                "error" => "Something went wrong please try again"
            ]
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id)->delete();

        if($post) {
            return response()->json([
                true
            ], 201);
        }
        return response()->json([
            false
        ], 201);
    }
}
