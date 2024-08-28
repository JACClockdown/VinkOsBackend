<?php



namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\CustomResponse;


class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        

        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        
        if (!$token) {
            return CustomResponse::error('Unauthorized');
        }

        $user = Auth::user();

        return CustomResponse::success([
            'user' => $user,
            'token' => $token,
            'type' => 'bearer',
        
        ]);
    }

    public function me()
    {
        return response()->json([
            "Usuario obtenido correctamente",
            ['user' => auth()->user()]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return CustomResponse::success('User created successfully',$user);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json('Successfully logged out');
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

}
