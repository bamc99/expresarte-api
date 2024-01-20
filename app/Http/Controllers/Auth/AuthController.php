<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignUpRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Signup User
    public function signup(SignUpRequest $request)
    {

        $signupData = $request->validated();

        $token = rand(100000, 999999);

        try {
            $newUser = new User([
                'name' => $signupData['name'],
                'verification_token' => $token,
                'email' => $signupData['email'],
                'password' => Hash::make($signupData['password']),
            ]);

            $newUser->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Error de base de datos',
                'errors' => $e->getMessage()
            ], 500);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Ocurrió un error al registrar el usuario.',
                'errors' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Usuario registrado exitosamente',
            'data' => $newUser,
        ], 200);
    }

    // Login User
    public function login(LoginRequest $request)
    {
        $loginData = $request->validated();

        $user = User::where('email', $loginData['email'])
            ->with('profile')
            ->first();

        if (!$user || !Hash::check($loginData['password'], $user->password)) {
            return response(
                [
                    'errors' =>
                    [
                        'email' =>
                        ['El correo o la contraseña son incorrectos']
                    ]
                ],
                422
            );
        }

        $tokens = $user->tokens();

        if ($tokens->count() > 0) {
            $user->tokens()->delete(); // Eliminar todos los tokens del usuario
        }

        $expiresAt = now()->addHours(8); // Crear el token con una expiración de 8 horas
        $accessToken = $user->createToken('access_token', ['*'], $expiresAt);

        return [
            'token' => [
                'accessToken' => $accessToken->plainTextToken,
                'expiresAt' => Carbon::parse($accessToken->accessToken->expires_at)->toIso8601String()
            ],
            'user' => $user
        ];
    }
}
