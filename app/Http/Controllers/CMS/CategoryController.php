<?php

namespace App\Http\Controllers\CMS;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (ControllersService::checkPermission('read-categories', 'admin')) {
            $categories = Category::withCount(['articles', 'authors'])->paginate(5);
            return view('cms.admin.categories.index', ['categoriesData' => $categories]);
        }
        return view('cms.blocked');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (ControllersService::checkPermission('create-category', 'admin')) {
            return view('cms.admin.categories.create');
        }
        return view('cms.blocked');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
        if (ControllersService::checkPermission('create-category', 'admin')) {
            $request->validate([
                'name_en' => 'required|String|min:5|max:45',
                'name_ar' => 'required|String|min:5|max:45',
                'status' => 'string'
            ]);

            $category = new Category();
            $category->name_en = $request->get('name_en');
            $category->name_ar = $request->get('name_ar');
            $category->status = $request->get('status') == 'on' ? 'Visible' : 'InVisible';

            $isSaved = $category->save();
            if ($isSaved) {
                $request->session()->flash('status', 'alert-success');
                $request->session()->flash('message', 'Category created successfully');
            } else {
                $request->session()->flash('status', 'alert-danger');
                $request->session()->flash('message', 'Category create failed!');
            }
            return redirect()->back();
        }
        return view('cms.blocked');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showArticles(Request $request, $id)
    {
        if (ControllersService::checkPermission('read-articles', 'admin')) {
            $articles = Category::findOrFail($id)->articles()->with(['category', 'author'])->paginate(10);
            return view('cms.admin.articles.index', ['articles' => $articles]);
        }
        return view('cms.blocked');
    }

    public function showAuthors($id)
    {
        if (ControllersService::checkPermission('read-authors', 'admin')) {
            $authors = Category::findOrFail($id)->authors()->paginate(10);
            return view('cms.admin.authors.index', ['authorsData' => $authors]);
        }
        return view('cms.blocked');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        //
        if (ControllersService::checkPermission('update-category', 'admin')) {
            $category = Category::find($id);
            return view('cms.admin.categories.edit', ['categoryData' => $category]);
        }
        return view('cms.blocked');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (ControllersService::checkPermission('update-category', 'admin')) {
            $request->request->add(['category_id' => $id]);
            $request->validate([
                'category_id' => 'required|exists:categories,id|integer',
                'name_en' => 'required|String|min:5|max:45',
                'name_ar' => 'required|String|min:5|max:45',
                'status' => 'string'
            ]);

            $category = Category::find($id);
            $category->name_en = $request->get('name_en');
            $category->name_ar = $request->get('name_ar');
            $category->status = $request->get('status') == 'on' ? 'Visible' : 'InVisible';
            $isUpdated = $category->save();
            if ($isUpdated) {
                return redirect()->route('categories.index');
            } else {
                echo "Category update failed";
            }
        }
        return view('cms.blocked');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
        //
        if (ControllersService::checkPermission('delete-category', 'admin')) {
            $isDeleted = Category::destroy($id);
            if ($isDeleted) {
                return response()->json(['icon' => 'success', 'title' => 'Category deleted successfully']);
            } else {
                return response()->json(['icon' => 'error', 'title' => 'Category delete failed']);
            }
        }
        return view('cms.blocked');
    }
}
