<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePermissionRequest;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function store(StorePermissionRequest $request){

        if (!$request->user()->hasPermission('permissions-create')) {
            return $this->sendError(__("common.unauthorized"));
        }

            return $request;
    }
}
