<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserProfileRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 25);
        $offset = $request->get('offset', 0);
        $searchTerm = $request->get('searchTerm', null);

        /** @var \App\Models\User $authUser **/
        $authUser = Auth::user();

        if (!$authUser) {
            return response()->json([
                'message' => 'No se encontró el usuario autenticado.',
                'errors' => []
            ], 400);
        }
        $userQuery = User::query()
            ->with(['profile', 'profile.branch']);

        if (empty($searchTerm)) {

            $admins = $userQuery->skip($offset)->take($limit)->get();
            $total = $userQuery->count();

            return response()->json([
                'users' => $admins,
                'total' => $total,
            ], 200);
        }

        $searchQuery = function ($q) use ($searchTerm) {
            $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
        };
        $profileQuery = function ($q) use ($searchTerm) {
            $q->where(DB::raw("CONCAT(last_name, ' ', middle_name)"), 'LIKE', '%' . $searchTerm . '%')
                ->orWhere(DB::raw("CONCAT(middle_name, ' ', last_name)"), 'LIKE', '%' . $searchTerm . '%');
        };

        $userQuery = $userQuery->where($searchQuery)
            ->orWhereHas('profile', $profileQuery);

        $users = $userQuery->skip($offset)->take($limit)->get();
        $total = $userQuery->count();

        return response()->json([
            'users' => $users,
            'total' => $total,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $userData = $request->validated();
        $token = rand(100000, 999999);

        DB::beginTransaction();
        try {
            $newUser = new User([
                'name' => $userData['first_name'] . ' ' . $userData['last_name'],
                'verification_token' => $token,
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            $newUser->save();

            $newUser->assignRole($userData['roles']);

            $newUserProfile = new UserProfile([
                'first_name' => $userData['first_name'],
                'middle_name' => $userData['middle_name'],
                'last_name' => $userData['last_name'],
                'second_last_name' => $userData['second_last_name'],
                'street' => $userData['street'],
                'house_number' => $userData['house_number'],
                'neighborhood' => $userData['neighborhood'],
                'city' => $userData['city'],
                'state' => $userData['state'],
                'postal_code' => $userData['postal_code'],
                'country' => $userData['country'],
                'phone' => $userData['phone'],
                'emergency_name' => $userData['emergency_name'],
                'emergency_phone' => $userData['emergency_phone'],
                'emergency_relationship' => $userData['emergency_relationship'],
                'date_of_birth' => $userData['date_of_birth'],
                'date_of_hire' => $userData['date_of_hire'],
                'nss' => $userData['nss'],
                'user_id' => $newUser->id,
                'branch_id' => $userData['branch_id'],
            ]);

            $newUserProfile->save();

            DB::commit();
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json([
                'message' => 'Error de base de datos',
                'errors' => $e->getMessage()
            ], 500);
        } catch (\Throwable $th) {
            DB::rollback();
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

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load(['profile', 'profile.branch']);


        return response()->json(['user' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        $userData = $request->validated();
        DB::beginTransaction();
        try {
            $user->update($userData);

            // Actualizar datos relacionados
            if (isset($userData['branch_id'])) {
                $user->profile()->update($userData['branch_id']);
            }

            if (isset($userData['roles'])) {
                $user->roles()->sync($userData['roles']);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => 'Error al actualizar el usuario', 'errors' => $th->getMessage()], 500);
        }
        return response()->json(['message' => 'Usuario actualizado exitosamente', 'user' => $user], 200);
    }

    public function updateProfile(UpdateUserProfileRequest $request, User $user)
    {
        $profileData = $request->validated();

        // Comprobar si el usuario tiene un perfil
        if (!$user->profile) {
            // Si no tiene un perfil, crea uno
            $profile = new UserProfile($profileData);
            $user->profile()->save($profile);
        } else {
            // Si ya tiene un perfil, actualiza los datos
            DB::beginTransaction();
            try {
                $user->profile()->update($profileData);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['error' => 'Error al actualizar el perfil', 'errors' => $th->getMessage()], 500);
            }
        }
    
        return response()->json(['message' => 'Perfil actualizado exitosamente', 'user' => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
