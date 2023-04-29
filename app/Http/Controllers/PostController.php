<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\Post;
use Illuminate\Support\Facades\Log;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = ['website','title','description'];

        foreach($fields as $field) {
            if (!$request->filled($field))
                return response(["error_text"=>"Missing input '$field'"], 400);

            $request->$field = trim($request->$field);

            if (strlen($request->$field) > 255)
                return response(["error_text"=>"Input '$field' too long"], 400);
        }
        
        $website = Website::where('title',$request->website)->first();
        if ($website) {
            $post = new Post();
            $post->website_id = $website->id;
            $post->title = $request->title;
            $post->description = $request->description;
            $result = $post->save();
            return response(["error_text"=>""], 200);
        } else 
            return response(["error_text"=>"Incorrect website name"], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
