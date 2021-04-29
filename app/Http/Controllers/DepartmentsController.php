<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Department;
use App\Models\User;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::all();
        return view('departments.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('departments.create',compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'department' => 'required|unique:departments',
                'manager' => 'required|unique:departments',
            ],
            [
                'manager.unique' => 'Department can only be managed by one user'
            ]
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if($request->manager === $request->assistant)
        {
            return back()->with('error','Please select different users for manager and assistant manager.');
        }

        // user can only manage his or her department
        $user_req = User::where('paynumber',$request->manager)->first();

        if($user_req->department == $request->department)
        {
            if(empty($request->assistant) || $request->assistant =="")
            {
                $department = Department::create([
                    'manager' => $request->input('manager'),
                    'department' => $request->input('department'),
                    'assistant' => '',
                ]);
                $department->save();
                return redirect('departments')->with('success','New Department has been created successfully');
            }
            else
            {
                $department = Department::create([
                    'manager' => $request->input('manager'),
                    'department' => $request->input('department'),
                    'assistant' => $request->input('assistant'),
                ]);
                $department->save();
                return redirect('departments')->with('success','New Department has been created successfully');
            }
        }
        else
        {
            return back()->with('error','User does not belong to the department.');
        }

        return redirect('departments')->with('error','Something went wrong.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::all();
        $department = Department::findOrFail($id);
        return view('departments.edit',compact('users','department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'department' => 'required',
            'manager' => 'required',
            ]
        );

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $department = Department::findOrFail($id);

        if($request->manager === $request->assistant)
        {
            return back()->with('error','Please select different users for manager and assistant manager.');
        }

        $user_req = User::where('paynumber',$request->manager)->first();

        if($user_req->department == $request->department)
        {
            if(empty($request->assistant) || $request->assistant =="")
            {
                $department->manager = $request->input('manager');
                $department->department = $request->input('manager');
                $department->save();
                return redirect('departments')->with('success','Department has been updated successfully');
            }
            else
            {
                $assistant_manager = User::where('paynumber',$request->assistant)->first();

                if ($assistant_manager->department == $request->department) {
                    $department->manager = $request->input('manager');
                    $department->department = $request->input('department');
                    $department->assistant = $request->input('assistant');
                    $department->save();

                    return redirect('departments')->with('success','Department has been updated successfully');
                }else {
                    return back()->with('error','Assistant manager selected is does not belong to the department.');
                }

            }
        }else {
            return back()->with('error','User does not belong to the department');
        }

        return back()->with('error','There is something wronng with your input');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect('departments')->with('success','Department has been deleted successfully.');
    }
}
