<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Tampilkan daftar artikel (skin guide).
     */
    public function index()
    {
        $articles = Article::published()
                           ->latest('published_at')
                           ->paginate(12);

        return view('pages.skin-guide', compact('articles'));
    }

    /**
     * Tampilkan detail artikel.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        // Pastikan artikel dipublikasikan
        if (!$article->is_published) {
            abort(404);
        }

        return view('pages.article-detail', compact('article'));
    }
}
