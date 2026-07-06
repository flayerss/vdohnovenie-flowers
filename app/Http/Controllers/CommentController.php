<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Type;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function getComments()
    {
        $comments = Comment::where('status_id', '3')->get();
        $types = Type::all();
        return view("feedback", compact("comments", 'types'));
    }
    public function addComment(Request $request)
    {
        Comment::create(
            [
                'name_user'=> $request->name,
                'name' => $request->comment,
                'status_id' => 1
            ]
        );
        $comments = Comment::where('status_id', '3')->get();
        $types = Type::all();
        return view("feedback", compact("comments", 'types'));
    }
}
