<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
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
            // if (auth('admin')->user()->hasPermissionTo('read-roles')) {
                $roles = Role::paginate(10);
                return view('cms.admin.spatie.roles.index', ['roles' => $roles]);
            // }
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
            // if (auth('admin')->user()->hasPermissionTo('create-role')) {
                return view('cms.admin.spatie.roles.create');
            // }
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
            'name' => 'required|String|min:5|max:45',
            'guard_name' => 'string|in:admin,author',
        ]);

        $role = new Role();
        $role->name = $request->get('name');
        $role->guard_name = $request->get('guard_name');
        $isSaved = $role->save();
        if ($isSaved) {
            return response()->json(['icon' => 'success', 'title' => 'Role created successfully'], 200);
        } else {
            return response()->json(['icon' => 'success', 'title' => 'Role create failed!'], 400);
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
            // if (auth('admin')->user()->hasPermissionTo('update-role')) {
                $role = Role::find($id);
                return view('cms.admin.spatie.roles.edit', ['role' => $role]);
            // }
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
            'id' => 'required|exists:roles,id|integer',
            'name' => 'required|String|min:5|max:45',
            'guard_name' => 'string|in:admin,student',
        ]);

        $role = Role::find($id);
        $role->name = $request->get('name');
        $role->guard_name = $request->get('guard_name');
        $isUpdated = $role->save();
        if ($isUpdated) {
            return response()->json(['icon' => 'success', 'title' => 'Role updated successfully'], 200);
        } else {
            return response()->json(['icon' => 'Failed', 'title' => 'Role update failed'], 400);
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
            if (auth('admin')->user()->hasPermissionTo('delete-role')) {
                $isDestroyed = Role::destroy($id);
            }
        }
        if ($isDestroyed) {
            return response()->json([
                'icon' => 'success',
                'title' => 'Role deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'icon' => 'error',
                'title' => 'Role delete failed'
            ], 400);
        }
    }

    public function editRolePermissions(Request $request, $id)
    {
        $role = Role::find($id);
        $rolePermissions = $role->permissions()->get();
        $permissions = Permission::where('guard_name', $role->guard_name)->get();
        return view('cms.admin.spatie.roles.edit-role-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions]);
    }

    public function updateRolePermissions(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:roles,id',
            'permissions' => 'array',
        ]);

        $role = Role::find($request->get('id'));
        $permissions = Permission::findMany($request->permissions);
        $isSynced = $role->syncPermissions($permissions);
        if ($isSynced) {
            return response()->json(['icon' => 'success', 'title' => 'Role updated successfully'], 200);
        } else {
            return response()->json(['icon' => 'Failed', 'title' => 'Role update failed'], 400);
        }
    }
}
