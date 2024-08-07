<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $peermissions = permission::get();
        return view('role-permission.permission.index', [
            'permissions' => $permissions
        ]);
    }
    public function create()
    {

        return view('role-permission.permission.create');
  
    }
    public function store(Request $request)
    {
       $request->validate([
        'name'=>[
            'required',
            'string',
            'unique:permissions,name'
        ]
        ]);
        permission::create([
            'name' => $request->name
        ]);
        return redirect('permissions')->with('status','Peermission Created Successfully');
    }

    public function edit()
    {
       return view('role-permission.permission.edit');
    }
    public function update()
    {
        
    }
    public function distroy()
    {
        
    }


}
