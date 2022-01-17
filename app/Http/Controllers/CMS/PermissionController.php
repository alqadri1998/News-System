<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //
        if (auth('admin')->check()) {
            if (auth('admin')->user()->hasPermissionTo('read-permissions')) {
                $permissions = Permission::paginate(10);
                return view('cms.admin.spatie.permissions.index', ['permissions' => $permissions]);
            }
        }
        return view('cms.no-content');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
        if (auth('admin')->check()) {
            if (auth('admin')->user()->hasPermissionTo('create-permission')) {
                return view('cms.admin.spatie.permissions.create');
            }
        }
        return view('cms.no-content');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|min:5|max:45',
            'guard_name' => 'string|in:admin,student',
        ]);

        $permission = new Permission();
        $permission->name = $request->get('name');
        $permission->guard_name = $request->get('guard_name');
        $isSaved = $permission->save();
        if ($isSaved) {
            return response()->json(['icon' => 'success', 'title' => 'Permission created successfully'], 200);
        } else {
            return response()->json(['icon' => 'success', 'title' => 'Permission create failed!'], 400);
        }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        //
        if (auth('admin')->check()) {
            if (auth('admin')->user()->hasPermissionTo('update-permission')) {
                $permission = Permission::find($id);
                return view('cms.admin.spatie.permissions.edit', ['permission' => $permission]);
            }
        }
        return view('cms.no-content');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        //
        $request->request->add(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:permissions,id|integer',
            'name' => 'required|string|min:5|max:45',
            'guard_name' => 'string|in:admin,student',
        ]);

        $permission = Permission::find($id);
        $permission->name = $request->get('name');
        $permission->guard_name = $request->get('guard_name');
        $isUpdated = $permission->save();
        if ($isUpdated) {
            return response()->json(['icon' => 'success', 'title' => 'Permission updated successfully'], 200);
        } else {
            return response()->json(['icon' => 'Failed', 'title' => 'Permission update failed'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        //
        $isDestroyed = false;
        if (auth('admin')->check()) {
            if (auth('admin')->user()->hasPermissionTo('delete-permission')) {
                $isDestroyed = Permission::destroy($id);
            }
        }
        if ($isDestroyed) {
            return response()->json([
                'icon' => 'success',
                'title' => 'Permission deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'icon' => 'error',
                'title' => 'Permission delete failed'
            ], 400);
        }
    }
}
