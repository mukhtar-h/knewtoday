<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Comment::class);

        $query = Comment::with(['post', 'user', 'parent'])
            ->latest();

        // Search: by comment body, author name, post title
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('body', 'like', "%{$search}%")
                    ->orWhere('guest_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('post', function ($q3) use ($search) {
                        $q3->where('title', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        // Filter by posts
        if ($postId = $request->get('post_id')) {
            $query->where('post_id', $postId);
        }

        $comments = $query->paginate(20)->withQueryString();

        // For filters
        $posts = Post::orderBy('title')->get();

        // Stats
        $total      = Comment::count();
        $approved   = Comment::where('status', 'approved')->count();
        $pending    = Comment::where('status', 'pending')->count();
        $spam       = Comment::where('status', 'spam')->count();
        $hidden     = Comment::where('status', 'hidden')->count();

        return view('admin.comments.index', compact('comments', 'posts', 'total', 'approved', 'pending', 'spam', 'hidden'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('moderate', $comment);

        $data = $request->validate([
            'status'    => ['required', 'string', 'in:pending,approved,spam,hidden'],
        ]);

        $comment->update($data);

        return redirect()
            ->back()
            ->with('status', 'Comment status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()
            ->back()
            ->with('status', 'Comment deleted.');
    }
}
