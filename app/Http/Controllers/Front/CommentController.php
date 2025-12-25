<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Notifications\CommentReplied;
use App\Notifications\PostCommented;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'body'              => ['required', 'string', 'max:2000', 'min:3'],
            'guest_name'        => ['nullable', 'string', 'max:255'],
            'guest_email'       => ['nullable', 'email', 'max:255'],
            'parent_id'         => ['nullable', 'exists:comments,id'],
        ]);

        $validator->sometimes(['guest_name', 'guest_email'], 'required', function ($input) {
            return ! Auth::check();
        });

        $data = $validator->validate();

        $parentId = $data['parent_id'] ?? null;

        if ($parentId) {
            $parent = Comment::where('post_id', $post->id)->findOrFail($parentId);

            if (! is_null($parent->parent_id)) {
                $parentId = $parent->parent_id;
            }
        }

        $comment                = new Comment();
        $comment->post_id       = $post->id;
        $comment->parent_id     = $parentId;


        if (Auth::check()) {
            $comment->user_id       = Auth::id();
            $comment->guest_name    = Auth::user()->name;
            $comment->guest_email   = Auth::user()->email;
            $comment->status        = 'approved';
        } else {
            $comment->guest_name  = $data['guest_name'];
            $comment->guest_email = $data['guest_email'];
            $comment->status      = 'approved';
        }

        $comment->body  = $data['body'];

        $comment->save();

        if ($comment->parent && $comment->parent->user) {
            $parentUser = $comment->parent->user;

            /**
             * Don't notify the user,
             * if they are replying to their own comment.
             */
            if ($parentUser->id !== $comment->user_id ?? null) {
                $parentUser->notify(new CommentReplied($comment));
            }
        }

        /**
         * Notify post author on any comment
         */
        $author = $post->author ?? $post->user ?? null;

        if ($author && $author->id !== $comment->user_id ?? null) {
            $author->notify(new PostCommented($comment));
        }

        return back()->with('success', 'Thank you for your comment! it may appear after moderation.');
    }
}
