<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Str;

class UsersManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('usersmanagement.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Department::all();
        $usertypes = Usertype::all();
        $roles = Role::all();
        return view('usersmanagement.create',compact('departments','usertypes','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(),
        [
            'paynumber' => 'required|max:255|unique:users|alpha_dash',
            'first_name' => 'required',
            'last_name' => 'required',
            'department' => 'required',
            'mobile' => 'required',
            'usertype' => 'required',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $first = substr($request->first_name,0,1);
        $username = Str::lower($first.$request->last_name);

        if($request->password == null || empty($request->password))
        {
            $user = User::create([
                'name' => $username,
                'email' => $request->input('email'),
                'paynumber' => strip_tags($request->input('paynumber')),
                'first_name' => strip_tags($request->input('first_name')),
                'last_name' => strip_tags($request->input('last_name')),
                'department' => $request->input('department'),
                'usertype' => $request->input('usertype'),
                'mobile' => $request->input('mobile'),
                'password' => Hash::make('password'),
                'token' =>str_random(64),
                'activated' => 1,
            ]);
            $user->attachRole($request->input('role'));
            $user->save();

            return redirect('users')->with('success','User has been created successfully');
        }
        else {
            if ($request->password === $request->confirm_password)
            {
                $user = User::create([
                    'name' => $username,
                    'email' => $request->input('email'),
                    'paynumber' => strip_tags($request->input('paynumber')),
                    'first_name' => strip_tags($request->input('first_name')),
                    'last_name' => strip_tags($request->input('last_name')),
                    'department' => $request->input('department'),
                    'usertype' => $request->input('usertype'),
                    'mobile' => $request->input('mobile'),
                    'password' => Hash::make($request->input('password')),
                    'token' =>str_random(64),
                    'activated' => 1,
                ]);
                $user->attachRole($request->input('role'));
                $user->save();

                return redirect('users')->with('success','User has been created successfully');
            }
            else {
                return back()->with('error','Password fields did not match.');
            }
        }

        return redirect()->back()->with('error','System was unable to create user account.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('usersmanagement.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $departments = Department::all();
        $usertypes = Usertype::all();
        $roles = Role::all();
        return view('usersmanagement.edit',compact('departments','usertypes','roles','user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $emailCheck = ($request->input('email') !== '') && ($request->input('email') !== $user->email);

        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'paynumber' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required',
            'department' => 'required',
            'usertype' => 'required',
            'role' => 'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $first = substr($request->first_name,0,1);
        $username = Str::lower($first.$request->last_name);

        $user->name = $username;
        $user->paynumber = strip_tags($request->input('paynumber'));
        $user->first_name = strip_tags($request->input('first_name'));
        $user->last_name = strip_tags($request->input('last_name'));
        $user->department = $request->input('department');
        $user->usertype = $request->input('usertype');
        $user->mobile = $request->input('mobile');

        if($emailCheck){
            $user->email = $request->input('email');
        }

        if($request->input('password') !== null){
            $user->password = Hash::make($request->input('password'));
        }

        $userRole = $request->input('role');
        if($userRole !== null){
            $user->detachAllRoles();
            $user->attachRole($userRole);
        }
        $user->save();

        return redirect('users')->with('success','User has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $currentUser = Auth::user();
        $user = User::findOrFail($id);

        if ($user->id != $currentUser->id) {
            $user->activated = 0;
            $user->save();
            $user->delete();
            return redirect('users')->with('success','User has been deleted successfully');
        }

        return back()->with('error','You cannot delete your own account.');
    }
}
