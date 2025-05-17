<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->paginate();
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name',
        ]);

        Permission::create(['name' => $request->name]);

        $alert = [
            'type' => 'Success',
            'message' => 'Successfully Stored',
        ];

        return redirect()->route('permission.index')->with($alert);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // show
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['permission'] = Permission::findOrFail($id);
        return view('admin.permission.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:permissions,name,' . $id,
        ]);

        $permission = Permission::findOrFail($id);

        $permission->update([
            'name' => $request->name,
        ]);

        $alert = [
            'type' => 'Success',
            'message' => 'Successfully Updated',
        ];
        return redirect()->route('permission.index')->with($alert);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        $alert = [
            'type' => 'Success',
            'message' => 'Successfully Deleted',
        ];
        return redirect()->back()->with($alert);
    }
}
