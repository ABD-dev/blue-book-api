<?php

namespace App\Api\V1\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JWTAuth;
use Tymon\JWTAuthExceptions\JWTException;

class LoginController extends Controller
{
  public function login(Request $request)
  {
      $credentials = $request->only('email', 'password');

      try {
          if (! $token = JWTAuth::attempt($credentials)) {
              return response()->json(['error' => 'Username/password invalid'], 401);
          }
      } catch (JWTException $e) {
          return response()->json(['error' => 'Could not create token'], 500);
      }

      return response()->json(compact('token'));
  }
}
