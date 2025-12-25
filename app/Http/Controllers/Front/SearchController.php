<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Enums\PostStatus;
use Illuminate\Http\Request;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $searchTerm = $request->query('q', '');
        $posts = collect();
        $total = 0;

        if ($request->filled('q')) {

            $data = $request->validate([
                'q' => ['required', 'string', 'max:100'],
            ]);

            $searchTerm = trim($data['q']);

            $postsQuery = Post::query()
                ->where('status', PostStatus::Published->value)
                ->where('updated_at', '<=', now())
                ->with(['category', 'tags']);

            $postsQuery->where(function ($sub) use ($searchTerm) {
                $sub->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('excerpt', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhereHas('category', function ($q2) use ($searchTerm) {
                        $q2->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('tags', function ($q3) use ($searchTerm) {
                        $q3->where('name', 'like', "%{$searchTerm}%");
                    });
            });

            $posts = $postsQuery->paginate(9)->withQueryString();
            $total = $posts->total();
        }
        return view('front.search', ['q' => $searchTerm, 'posts' => $posts, 'total' => $total]);
    }
}
