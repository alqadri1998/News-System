<?php

namespace App\Http\Controllers\CMS;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllersService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (ControllersService::checkPermission('read-admins', 'admin')) {
            $admins = Admin::all();
            return view('cms.admin.admins.index', ['adminsData' => $admins]);
        }
        return view('cms.blocked');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (ControllersService::checkPermission('create-admin', 'admin')) {
            return view('cms.admin.admins.create');
        }
        return view('cms.blocked');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function store(Request $request)
    {
        //
        if (ControllersService::checkPermission('create-admin', 'admin')) {
            $request->validate([
                'name' => 'required|string|min:3',
                'email' => 'required:string|email|unique:admins,email',
                'mobile' => 'required|string|numeric|unique:admins,mobile',
                'gender' => 'required|string|in:Male,Female',
                'age' => 'required|integer|min:16|max:100',
                'account_status' => 'string|in:Active,Blocked'
            ]);

            $admin = new Admin();
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->gender = $request->get('gender');
            $admin->age = $request->get('age');
            $admin->status = $request->get('status');
            $admin->password = Hash::make("Pass123$");
            $isSaved = $admin->save();

            if ($isSaved) {
                $admin->assignRole('Admin');
                return response()->json(['icon' => 'success', 'title' => 'Admin created successfully'], 200);
            } else {
                return response()->json(['icon' => 'success', 'title' => 'Admin created successfully'], 400);
            }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     */
    public function edit($id)
    {
        //
        if (ControllersService::checkPermission('update-admin', 'admin')) {
            $admin = Admin::find($id);
            return view('cms.admin.admins.edit', ['admin' => $admin]);
        }
        return view('cms.blocked');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        //
        if (ControllersService::checkPermission('update-admin', 'admin')) {
            $request->request->add(['id' => $id]);
            $request->validate([
                'id' => 'required|exists:admins,id',
                'name' => 'required|string|min:3',
                'email' => 'required:string|email|unique:admins,email,' . $id,
                'mobile' => 'required|string|numeric|unique:admins,mobile,' . $id,
                'gender' => 'required|string|in:Male,Female',
                'age' => 'required|integer|min:16|max:100',
                'account_status' => 'string|in:Active,Blocked'
            ]);

            $admin = Admin::find($id);
            $admin->name = $request->get('name');
            $admin->email = $request->get('email');
            $admin->mobile = $request->get('mobile');
            $admin->gender = $request->get('gender');
            $admin->age = $request->get('age');
            $admin->status = $request->get('status');
            $isSaved = $admin->save();

            if ($isSaved) {
                return response()->json(['icon' => 'success', 'title' => 'Admin updated successfully'], 200);
            } else {
                return response()->json(['icon' => 'Failed', 'title' => 'Admin update failed'], 400);
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
        if (ControllersService::checkPermission('delete-admin', 'admin')) {
            $isDestroyed = Admin::destroy($id);
            if ($isDestroyed) {
                return response()->json([
                    'icon' => 'success',
                    'title' => 'Admin deleted successfully'
                ], 200);
            } else {
                return response()->json([
                    'icon' => 'error',
                    'title' => 'Admin delete failed'
                ], 400);
            }
        }
        return view('cms.blocked');
    }

    public function editPermissions(Request $request, $id)
    {
        $admin = Admin::find($id);
        $adminPermissions = $admin->permissions()->get();
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('cms.admin.admins.edit-admin-permissions', [
            'admin' => $admin,
            'permissions' => $permissions,
            'adminPermissions' => $adminPermissions]);
    }

    public function updatePermissions(Request $request, $id)
    {
        $request->request->add(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:admins,id',
            'permissions' => 'array',
        ]);

        $admin = Admin::find($request->get('id'));
        $permissions = Permission::findMany($request->permissions);
        $isSynced = $admin->syncPermissions($permissions);
        if ($isSynced) {
            return response()->json(['icon' => 'success', 'title' => 'Admin permissions updated successfully'], 200);
        } else {
            return response()->json(['icon' => 'Failed', 'title' => 'Admin permissions update failed'], 400);
        }
    }
}
