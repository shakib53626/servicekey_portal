<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use App\Http\Requests\Admin\AdminRegisterRequest;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\ResetPasswordRequest;
use App\Http\Resources\Admin\AdminAuthResource;
use App\Http\Resources\Admin\ResetPasswordRequestListResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
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

            $token =  $admin->createToken('admin-token')->plainTextToken;
            $data = [
                'success' => true,
                'user' => $admin,
                'token' => $token,
            ];
            return response()->json($data);

        }else{
            return send_ms('Your Account is Not Approved Right Now.', true, 403);
        }
    }

    public function register(AdminRegisterRequest $request){
        try {

            $admin = Admin::create($request->validated());

            if($admin->is_verified){
                $token = $admin->createToken('admin-token')->plainTextToken;
                $data  = [
                    'success' => true,
                    'user'    => $admin,
                    'token'   => $token,
                ];
                return response()->json($data);
            }else{
                return send_ms('Waiting for admin verified', true, 200);
            }

        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function changePassword(ChangePasswordRequest $request){
        try {
            $admin = Admin::where('id', Auth::user()->id)->first();
            if(Hash::check($request->old_password, $admin->password)){
                $admin->password = $request->new_password;
                $admin->save();
                return send_ms('Password Changed Successfuly', true, 200);
            }else{
                return send_ms('Incorrect old password', false, 201);
            }

        } catch (\Exception $th) {
            throw $th;
        }
    }

    public function resetPassword(ResetPasswordRequest $request){
        try {
            $admin = Admin::where('email', $request->email_phone)
                        ->orWhere('phone', $request->email_phone)
                        ->first();

            $admin->tmp_password = $request->password;
            $admin->save();

            return send_ms('Reset Password Application Successfully Submit', true, 200);

        } catch (\Exception $th) {
            throw $th;
        }
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

    public function resetPasswordRequestList(){
        try {
            $admin = Admin::whereNotNull('tmp_password')->get();

            $data = [
                'success' => true,
                'data'    => ResetPasswordRequestListResource::collection($admin),
            ];
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function resetPasswordApproval(Request $request){


        if($request->approve_id){

            $admin = Admin::where('id', $request->approve_id)->first();
            $admin->password = $admin->tmp_password;
            $admin->tmp_password = null;
            $admin->save();
            return send_ms('User Password Changed Successfully', true, 200);

        }else{

            $admin = Admin::where('id', $request->remove_id)->first();
            $admin->tmp_password = null;
            $admin->save();
            return send_ms('User Password Changed Request Removed', true, 200);

        }
    }
}
