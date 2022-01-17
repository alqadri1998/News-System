<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return view('cms.admin.users.index', ['usersData' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('cms.admin.users.create');
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
        $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required:string|email',
            'mobile' => 'required|string|numeric',
            'gender' => 'required|string|in:Male,Female',
            'age' => 'required|integer|min:16|max:100',
            'account_status' => 'string'
        ]);

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->mobile = $request->get('mobile');
        $user->password = Hash::make('1234');
        $user->age = $request->get('age');
        $user->gender = $request->get('gender');
        $user->status = $request->get('account_status') == 'on' ? 'Active' : 'Blocked';
        $isSaved = $user->save();
        if ($isSaved) {
            session()->flash('status', 'alert-success');
            session()->flash('message', 'User created successfully');
        } else {
            session()->flash('status', 'alert-danger');
            session()->flash('message', 'User create failed!');
        }
        return redirect()->back();
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
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('cms.admin.users.edit', ['user' => $user]);
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
        //
        $request->request->add(['id' => $id]);
        $request->validate([
            'id' => 'required|exists:users',
            'name' => 'required|String|min:3',
            'email' => 'required:String|email',
            'mobile' => 'required|String|numeric',
            'gender' => 'required|String|in:Male,Female',
            'age' => 'required|integer|min:16|max:100',
            'account_status' => 'String|in:on',
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->mobile = $request->get('mobile');
        $user->password = Hash::make('1234');
        $user->age = $request->get('age');
        $user->gender = $request->get('gender');
        $user->status = $request->get('account_status') == "on" ? 'Active' : 'Blocked';
        $isSaved = $user->save();
        if ($isSaved) {
            return redirect()->route('users.index');
        } else {
            return redirect()->route('users.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $isDestroyed = User::destroy($id);
        if ($isDestroyed) {
            return response()->json([
                'icon' => 'success',
                'title' => 'User deleted successfully'
            ], 200);
        } else {
            return response()->json([
                'icon' => 'error',
                'title' => 'User delete failed'
            ], 400);
        }
    }
}
