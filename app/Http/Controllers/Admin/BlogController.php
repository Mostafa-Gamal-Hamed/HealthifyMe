<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Jobs\SendNewsletterJob;
use App\Models\Blog;
use App\Models\BlogLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderby('id', 'desc')->paginate(30);

        return view("admin.blog.index", compact("blogs"));
    }

    public function create()
    {
        return view("admin.blog.create");
    }

    public function store(BlogRequest $request)
    {
        $userId = Auth::id();

        $data = $request->validated();
        $data['user_id'] = $userId;

        // Image
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs');
            $data['image'] = $imagePath;
        }

        // Insert data
        $blog = Blog::create($data);

        // Send news to all newsLetter
        dispatch(new SendNewsletterJob($blog));

        return redirect()->back()->with("success", "Blog created successfully");
    }

    public function show(string $id)
    {
        $blog     = Blog::findOrFail($id);
        $likes    = BlogLike::where('blog_id', $id)->where('status', 'like')->get();
        $disLikes = BlogLike::where('blog_id', $id)->where('status', 'dislike')->get();

        return view("admin.blog.show", compact("blog", "likes", "disLikes"));
    }

    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);

        return view("admin.blog.edit", compact("blog"));
    }

    public function update(BlogRequest $request, string $id)
    {
        $blog   = Blog::findOrFail($id);
        $userId = Auth::id();

        // Image
        if ($request->hasFile("image")) {
            // Remove old image
            if ($blog->image) {
                Storage::delete($blog->image);
            }

            $newImage = Storage::putFile("blogs", $request->validated()['image']);
        } else {
            $newImage = $blog->image;
        }

        $blog->update([
            'title'   => $request->validated()['title'],
            'slug'    => $request->validated()['slug'],
            'desc'    => $request->validated()['desc'],
            'image'   => $newImage,
            'user_id' => $userId,
        ]);

        return redirect()->back()->with("success", "Blog updated successfully");
    }

    public function destroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if($blog->image != null) {
            Storage::delete($blog->image);
        }

        $blog->delete();

        return redirect()->back()->with("success", "Blog deleted successfully");
    }

    public function secondDestroy(string $id)
    {
        $blog = Blog::findOrFail($id);

        if($blog->image != null) {
            Storage::delete($blog->image);
        }

        $blog->delete();

        return redirect()->route("admin.blog.blogs")->with("success", "Blog deleted successfully");
    }

    public function search(string $search)
    {
        $blog = Blog::where('Slug', 'like', "%{$search}%")->first();

        return response()->json(['blog' => $blog]);
    }
}
