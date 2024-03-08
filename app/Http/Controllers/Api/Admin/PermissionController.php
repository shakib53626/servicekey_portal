<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionRequest;
use App\Http\Requests\Admin\UpdatePermissionRequest;
use Illuminate\Support\Str;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{

    public function index(){
        try {
            $permission = Permission::orderBy('display_name', 'asc')->paginate(50);
            return sendResponse($permission, true, "All Permission List", 200);
        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function show($id){
        try {

            $permission = Permission::where('id', $id)->first();

            if(!$permission){
                return send_ms("Permission Not Found", false, 404);
            }

            return sendResponse($permission, true, "Single Permission Data", 200);

        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function store(StorePermissionRequest $request){

        // if (!$request->user()->hasPermission('permissions-create')) {
        //     return $this->sendError(__("common.unauthorized"));
        // }

        try {

            $permission = new Permission();

            $permission->name         = Str::slug($request->display_name, '_');
            $permission->display_name = $request->display_name;
            $permission->description  = $request->description;
            $permission->save();

            return send_ms('Permission Created Successfully', true, 200);

        } catch (\Exception $th) {
            throw $th;
        }

    }

    public function update(UpdatePermissionRequest $request, $id){
        try {

            $permission = Permission::find($id);
            if(!$permission){
                return send_ms("Permission Not Found", false, 404);
            }

            $permission->display_name = $request->display_name;
            $permission->description = $request->description;
            $permission->name = Str::slug($request->display_name, '_');
            $permission->save();

            return send_ms('Permission Updated Successfully', true, 200);

        } catch (\Exception $th) {
            throw $th;
        }
    }
}
