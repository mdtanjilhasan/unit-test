<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidation;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function login(LoginValidation $request) : array
    {
        $data = $request->validated();
        $response = [];
        try {
            if ( Auth::attempt($data) ) {
                $authUser = Auth::user();
                $response['token'] = $authUser->createToken('MyAuthApp')->plainTextToken;
                $response['user'] = $authUser;
                $response['message'] = 'Login Successful.';
                return $response;
            }
            return ['message' => 'Password Does Not Match.'];
        } catch (Exception $exception) {
            return ['message' => $exception->getMessage()];
        }
    }
}
