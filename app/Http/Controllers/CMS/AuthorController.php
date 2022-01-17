<?php

namespace App\Http\Controllers\CMS;

use App\Article;
use App\Author;
use App\Category;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $authors = Author::withCount('categories','articles')->paginate(10);
        return view('cms.admin.authors.index', ['authorsData' => $authors]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::where('status', 'Visible')->get();
        return view('cms.admin.authors.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|unique:authors',
            'mobile' => 'required|numeric|unique:authors',
            'age' => 'required|integer|min:16|max:100',
            'author_image' => 'required|image',
            'gender' => 'required|in:Male,Female',
            'account_status' => 'string',
            'category_id' => 'required|exists:categories,id|integer'
        ]);


        $author = new Author();
        $author->name = $request->get('name');
        $author->email = $request->get('email');
        $author->mobile = $request->get('mobile');
        $author->age = $request->get('age');
        $author->password = Hash::make('1234');

        $authorImage = $request->file('author_image');
        $timeNow = Carbon::now();

        $time = $timeNow->minute . '_' . $timeNow->second;
        $imageName = $time .'_'. $request->get('name');

        $authorImage->move('images/authors', $imageName);
        $author->image = $imageName;

        $author->gender = $request->get('gender');
        $author->status = $request->get('account_status') == 'on' ? "Active" : "Blocked";
        $isSaved = $author->save();

        $author->categories()->sync([$request->get('category_id')]);

        if ($isSaved) {
            $author->assignRole('author');
            session()->flash('status', 'alert-success');
            session()->flash('message', 'Author created successfully');
        } else {
            session()->flash('status', 'alert-danger');
            session()->flash('message', 'Author create failed!');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        //
        $author = Author::find($id);
        return view('cms.admin.authors.edit', ['author' => $author]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $request->request->add(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:authors,id',
            'name' => 'required|string|min:3|max:30',
            'email' => 'required|string|email|unique:authors,email,' . $id,
            'mobile' => 'required|numeric|unique:authors,mobile,' . $id,
            'age' => 'required|integer|min:16|max:100',
            'author_image' => 'image',
            'gender' => 'required|in:Male,Female',
            'account_status' => 'string'
        ]);

        $author = Author::find($id);
        $author->name = $request->get('name');
        $author->email = $request->get('email');
        $author->mobile = $request->get('mobile');
        $author->age = $request->get('age');

        if ($request->hasFile('author_image')) {
            $authorImage = $request->file('author_image');
            $imageName = now() . '_' . $request->get('name');
            $authorImage->move('images/authors', $imageName);
            $author->image = $imageName;
        }

        $author->gender = $request->get('gender');
        $author->status = $request->get('account_status') == 'on' ? "Active" : "Blocked";
        $isSaved = $author->save();
        if ($isSaved) {
            session()->flash('status', 'alert-success');
            session()->flash('message', 'Author updated successfully');
        } else {
            session()->flash('status', 'alert-danger');
            session()->flash('message', 'Author update failed!');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $isDeleted = Author::destroy($id);
        if ($isDeleted) {
            return response()->json(['icon' => 'success', 'title' => 'Author deleted successfully']);
        } else {
            return response()->json(['icon' => 'error', 'title' => 'Author delete failed']);
        }
    }

    public function showArticles($id)
    {
        $articles = Author::findOrFail($id)->articles()->paginate(10);
        return view('cms.admin.articles.index', ['articles' => $articles]);
    }

    public function showCategories($id){
        $categories = Author::findOrFail($id)->categories()->paginate(10);
        return view('cms.admin.categories.index', ['categoriesData' => $categories]);
    }
}
