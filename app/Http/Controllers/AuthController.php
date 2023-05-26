<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as FacadesValidator;


class AuthController extends Controller
{
    //
    public function login()
    {
        try {
            if (!Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                return response()->json(['status' => false, 'error' => 'Tài khoản hoặc mật khẩu không đúng'], 401);
            }
            /** @var \App\Models\User $user **/
            $user = Auth::user();
            $createToken = $user->createToken('Servey');
            $user['token'] = 'Bearer ' . $createToken->accessToken;
            $user['expiresAt'] = $createToken->token->expires_at;
            return response()->json(['status' => true, 'message' => 'Success', 'data' => $user], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
    public function register(Request $request)
    {
        try {
            $validator = FacadesValidator::make($request->all(), [
                'department_id' => 'required',
                'status' => 'required',
                'role' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Lỗi'], 400);
            }
            $input = $request->all();
            $department = Department::find($input['department_id']);
            if (!$department) {
                return response()->json([
                    'status' => false,
                    'message' => 'department not found'
                ], 400);
            }
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            return response()->json(['status' => true, 'message' => 'Success', 'data' => $user], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
    public function resetPassword(Request $request)
    {
        try {
            $validator = FacadesValidator::make($request->all(), [
                'id' => 'required',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => $validator->errors()], 400);
            }
            $input = $request->all();
            $user = User::find($input['id']);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ], 400);
            }
            $input['password'] = bcrypt($input['password']);
            $user->update($input);
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $user
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
    public function getUser()
    {
        try {
            $userId = auth('api')->user()->id;
            $user = User::find($userId);
            if ($user === null) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found',
                ], 400);
            }
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
    public function getAllUser(Request $request)
    {
        try {
            $departmentId = $request->query('departmentId');
            $user = User::all();
            foreach ($user as $item) {
                $item['department'] = Department::select('name', 'code')->where('id', '=', $item['department_id'])->get();
                $item['department'] = $item['department'][0];
            }
            if ($departmentId === null) {
                return response()->json([
                    'status' => true,
                    'message' => 'Success',
                    'data' => $user
                ], 200);
            }
            $users = [];
            foreach ($user as $item) {
                if ($item['department_id'] === (int)$departmentId)
                    array_push($users, $item);
            }
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $users
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
    public function updateUser(Request $request, $id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                ], 400);
            }
            $input = $request->all();
            $input['department_id'] = $request->input('department_id');
            $department = Department::find($input['department_id']);
            if ($input['department_id'] !== null && !$department) {
                return response()->json([
                    'status' => false,
                    'message' => 'department not found',
                ], 400);
            }

            if ($input['department_id'] === null) {
                $input['department_id'] = $user['department_id'];
            }
            $user->update($input);
            return response()->json([
                'status' => true,
                'message' => 'Success',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
    public function deleteUser($id)
    {
        try {
            $user = User::find($id);
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'user not found',
                ], 400);
            }
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Success',

            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e
            ], 500);
        }
    }
}
