<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreRoleRequest;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store(StoreRoleRequest $request){
        return $request;
    }
}
