<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    /**
     * Make the class invokable.
     *
     * @param Request $request 
     */
    public function __invoke(Request $request)
    {
        $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return ResponseBuilder::asSuccess()
            ->withData(['token' => $token])
            ->build();
    }
}
