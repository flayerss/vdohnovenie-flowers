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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string|max:2000',
        ]);
        Comment::create(
            [
                'name_user'=> $validated['name'],
                'name' => $validated['comment'],
                'status_id' => 1
            ]
        );
        $comments = Comment::where('status_id', '3')->get();
        $types = Type::all();
        return view("feedback", compact("comments", 'types'));
    }
}
