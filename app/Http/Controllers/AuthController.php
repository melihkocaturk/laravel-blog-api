<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $output = new \Symfony\Component\Console\Output\ConsoleOutput();
        $output->writeln($attr);

        if (!Auth::attempt($attr)) {
            return response('Credentials not match', 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json(['access-token', $token]);
    }
}
