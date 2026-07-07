<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Post;
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
                ->published()
                ->matchingSearch($searchTerm, includeRelations: true)
                ->with(['category', 'tags'])
                ->latest('updated_at');

            $posts = $postsQuery->paginate(9)->withQueryString();
            $total = $posts->total();
        }

        return view('front.search', ['q' => $searchTerm, 'posts' => $posts, 'total' => $total]);
    }
}
