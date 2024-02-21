<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRegisterRequest;
use App\Http\Resources\Admin\AdminAuthResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AdminAuthController extends Controller
{


    public function login(AdminLoginRequest $request)
    {
        $admin = Admin::where('phone', $request->phone)->first();

        if($admin->is_verified){

            if (!$admin || !Hash::check($request->password, $admin->password)) {
                throw ValidationException::withMessages([
                    'phone' => ['The provided credentials are incorrect.'],
                ]);
            }

            return $this->makeToken($admin);

        }else{
            return send_ms('Your Account is Not Approad Right Now.', true, 403);
        }
    }

    public function register(AdminRegisterRequest $request){
        try {

            $admin = Admin::create($request->validated());

            if($admin->is_verified){
                return $this->makeToken($admin);
            }else{
                return send_ms('Waiting for admin verified', true, 200);
            }

        } catch (\Exception $th) {
            throw $th;
        }
    }


    public function makeToken($admin)
    {
        $token =  $admin->createToken('admin-token')->plainTextToken;
        $data = [
            'success' => true,
            'user' => $admin,
            'token' => $token,
        ];
        return response()->json($data);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return send_ms('Admin Logout Successfully', true, 200);
    }

    public function user(Request $request)
    {
        return AdminAuthResource::make($request->user());
    }
}
