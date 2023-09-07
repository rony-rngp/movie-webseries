<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Favourite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function comment_store(Request $request, $movie_id)
    {
        $this->validate($request, [
           'comment' => 'required',
        ]);

        $comment = new Comment();
        $comment->movie_id = $movie_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = 0;
        $comment->comment = $request->comment;
        $comment->save();

        notify()->success('Comment Successfully Added', 'Success');
        return redirect()->back();
    }

    public function comment_reply_store(Request $request, $movie_id, $comment_id)
    {
        if ($request->comment == ''){
            notify()->warning('Filed must not be empty', 'Error');
            return redirect()->back();
        }

        $comment = new Comment();
        $comment->movie_id = $movie_id;
        $comment->user_id = Auth::user()->id;
        $comment->parent_id = $comment_id;
        $comment->comment = $request->comment;
        $comment->save();

        notify()->success('Reply Successfully Added', 'Success');
        return redirect()->back();
    }

    public function favorite_post($movie_id)
    {
        $user = Auth::user();
        $is_favorite  = Favourite::where(['movie_id' => $movie_id, 'user_id' => $user->id])->count();
        if ($is_favorite == 0){
            $favorite = new Favourite();
            $favorite->movie_id = $movie_id;
            $favorite->user_id = $user->id;
            $favorite->save();
            notify()->success('Added Your Favorite', 'Success');
            return redirect()->back();
        }else{
            Favourite::where(['movie_id' => $movie_id, 'user_id' => $user->id])->delete();
            notify()->success('Remove Your Favorite', 'Success');
            return redirect()->back();
        }

    }
}
