<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogLike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit  = 9;

        $blogs  = Blog::latest()
            ->skip($offset)
            ->take($limit)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'blogs' => $blogs,
                'hasMore' => $blogs->count() >= $limit
            ]);
        }

        return view("user.blog.index", compact("blogs"));
    }

    public function show(string $id)
    {
        $blog = Blog::findOrFail($id);

        return view("user.blog.show", compact("blog"));
    }

    public function like($id)
    {
        // Check if user is already liked this blog
        if (Auth::check()) {
            $blog     = Blog::find($id);
            $userId   = Auth::user()->id;
            $blogLike = BlogLike::where('blog_id', $blog->id)->where('user_id', $userId)->first();

            // Delete dislike if user is already liked this blog
            if($blogLike && $blogLike->status === "like"){
                $blogLike->delete();

                $likesCount    = $blog->likes()->where('status', 'like')->count();
                $disLikesCount = $blog->likes()->where('status', 'dislike')->count();

                return response()->json(['likes_count' => $likesCount, 'disLikes_count' => $disLikesCount]);
            }

            // Create or update user is already liked this blog
            if ($blog) {
                BlogLike::updateOrCreate(
                    [
                        'blog_id' => $blog->id,
                        'user_id' => $userId,
                    ],
                    ['status' => 'like']
                );

                $likesCount    = $blog->likes()->where('status', 'like')->count();
                $disLikesCount = $blog->likes()->where('status', 'dislike')->count();

                return response()->json(['likes_count' => $likesCount, 'disLikes_count' => $disLikesCount]);
            }
            return response()->json(['error' => 'Blog not found'], 404);
        }

        return response()->json(['location' => 'login']);
    }

    public function disLike($id)
    {
        // Check if user is already liked this blog
        if (Auth::check()) {
            $blog     = Blog::find($id);
            $userId   = Auth::user()->id;
            $blogLike = BlogLike::where('blog_id', $blog->id)->where('user_id', $userId)->first();

            // Delete dislike if user is already liked this blog
            if($blogLike && $blogLike->status === "dislike"){
                $blogLike->delete();

                $likesCount    = $blog->likes()->where('status', 'like')->count();
                $disLikesCount = $blog->likes()->where('status', 'dislike')->count();

                return response()->json(['likes_count' => $likesCount, 'disLikes_count' => $disLikesCount]);
            }

            // Create or update user is already liked this blog
            if ($blog) {
                BlogLike::updateOrCreate(
                    [
                        'blog_id' => $blog->id,
                        'user_id' => Auth::user()->id,
                    ],
                    ['status' => 'dislike']
                );

                $likesCount    = $blog->likes()->where('status', 'like')->count();
                $disLikesCount = $blog->likes()->where('status', 'dislike')->count();

                return response()->json(['likes_count' => $likesCount, 'disLikes_count' => $disLikesCount]);
            }

            return response()->json(['error' => 'Blog not found'], 404);
        }
        return response()->json(['location' => 'login']);
    }
}
