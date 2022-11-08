<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
 
class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email', 
            'password' => 'required'
        ]);
 
        if (Auth::attempt($credentials)) {
            $find = User::where("email", $request->email)->first();
            $token = $find->createToken('myAppToken')->plainTextToken;

            session()->put('user_data', json_encode($find));
            session()->put('user_token', $token);

            return response()->json(['status' => true, 'message' => 'Login success', 'data' => $token]);
        }
        return response()->json(['status' => false, 'message' => 'Login failed'], 409);
    }

    public function logout(Request $request) {
        session()->forget('user_data');
        session()->forget('user_token');
        Auth::user()->tokens()->delete();
    
        return response()->json('Successfully logged out');
    }
}