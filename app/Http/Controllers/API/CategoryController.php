<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::where('status', 'Visible')->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $categories
        ]);
        //return ControllersService::generateArraySuccessResponse($categories,"Success");
    }

    public function showCategoryArticles(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $roles = [
            'id' => 'required|exists:categories,id|integer',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $articles = Category::find($id)->articles()->with('author')->get();
            return ControllersService::generateArraySuccessResponse($articles, "Success");
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $roles = [
            'name_en' => 'required|string|min:3',
            'name_ar' => 'required|string|min:3',
        ];
        $validator = Validator::make($request->all(), $roles);
        if (!$validator->fails()) {
            $category = new Category();
            $category->name_en = $request->get('name_en');
            $category->name_ar = $request->get('name_ar');
            $isSaved = $category->save();
            if ($isSaved) {
                return ControllersService::generateProcessResponse(true, 'CREATE_SUCCESS');
            }
        } else {
            return ControllersService::generateValidationErrorMessage($validator->getMessageBag()->first());
        }
    }
}
