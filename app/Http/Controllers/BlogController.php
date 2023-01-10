<?php

namespace App\Http\Controllers;

use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Collection;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $blogs = Blog::paginate(5);
        // return $blogs;
        return Inertia::render('Blogs/Index',['blogs' => $blogs]);

        // $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
        //     $query->where(function ($query) use ($value) {
        //         Collection::wrap($value)->each(function ($value) use ($query) {
        //             $query
        //                 ->orWhere('title', 'LIKE', "%{$value}%")
        //                 ->orWhere('slug', 'LIKE', "%{$value}%");
        //         });
        //     });
        // });

        // $blogs = QueryBuilder::for(Blog::class)
        // ->defaultSort('created_at')
        // ->allowedSorts(['title', 'slug', 'created_at', 'id'])
        // ->allowedFilters(['title', 'slug', $globalSearch])
        // ->paginate($request->perPage)
        // ->withQueryString();
        
        // return Inertia::render('Blogs/Index', ['blogs' => $blogs])->table(function (InertiaTable $table) {
        //     $table->withGlobalSearch();
        //     $table->column('id', 'ID', searchable: true, sortable: true);
        //     $table->column('title', 'Title', searchable: true, sortable: true);
        //     $table->column('slug', 'Slug', searchable: true, sortable: true);
        //     $table->column('created_at', 'Created Date', searchable: true, sortable: true);
        //     $table->column('actions', 'Actions');
        // });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Blogs/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $request)
    {
        
        Blog::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->slug),
            'content' => $request->content
        ]);
        sleep(1);
        
        return redirect()->route('blogs.index')->with('message', 'Blog created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return Inertia::render('Blogs/Edit', ['blog' => $blog]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $blog->title = $request->title;
        $blog->slug = \Str::slug($request->slug);
        $blog->content = $request->content;
        $blog->save();
        sleep(1);

        return redirect()->route('blogs.index')->with('message', 'Blog Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        sleep(1);

        return redirect()->route('blogs.index')->with('message', 'Blog Delete Successfully');
    }
}
