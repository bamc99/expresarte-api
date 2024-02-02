<?php

namespace App\Http\Controllers;

use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientProfileRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use App\Models\ClientProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit', 25);
        $offset = $request->get('offset', 0);
        $searchTerm = $request->get('searchTerm', null);

        $clientQuery = Client::query()
            ->with(['profile']);

        if (empty($searchTerm)) {

            $clients = $clientQuery->skip($offset)->take($limit)->get();
            $total = $clientQuery->count();

            return response()->json([
                'clients' => $clients,
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

        $clientQuery = $clientQuery->where($searchQuery)
            ->orWhereHas('profile', $profileQuery);

        $clients = $clientQuery->skip($offset)->take($limit)->get();
        $total = $clientQuery->count();

        return response()->json([
            'clients' => $clients,
            'total' => $total,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $clientData = $request->validated();
        $token = rand(100000, 999999);

        DB::beginTransaction();
        try {
            $newClient = new Client([
                'name' => $clientData['first_name'] . ' ' . $clientData['last_name'],
                'verification_token' => $token,
                'email' => $clientData['email'],
                'password' => Hash::make($clientData['password']),
            ]);

            $newClient->save();

            $newClientProfile = new ClientProfile([
                'first_name' => $clientData['first_name'],
                'middle_name' => $clientData['middle_name'],
                'last_name' => $clientData['last_name'],
                'second_last_name' => $clientData['second_last_name'],
                'street' => $clientData['street'],
                'house_number' => $clientData['house_number'],
                'neighborhood' => $clientData['neighborhood'],
                'city' => $clientData['city'],
                'state' => $clientData['state'],
                'postal_code' => $clientData['postal_code'],
                'country' => $clientData['country'],
                'phone' => $clientData['phone'],
                'date_of_birth' => $clientData['date_of_birth'],
                'date_of_first_visit' => $clientData['date_of_first_visit'],
                'client_id' => $newClient->id,
            ]);

            $newClientProfile->save();

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
                'message' => 'Ocurrió un error al registrar el cliente.',
                'errors' => $th->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'Cliente registrado exitosamente',
            'data' => $newClient,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load(['profile']);


        return response()->json(['client' => $client], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $clientData = $request->validated();
        DB::beginTransaction();
        try {
            $client->update($clientData);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => 'Error al actualizar el cliente', 'errors' => $th->getMessage(), 'client'=>$client], 500);
        }
        return response()->json(['message' => 'Cliente actualizado exitosamente'], 200);
    }

    public function updateProfile(UpdateClientProfileRequest $request, Client $client)
    {
        $profileData = $request->validated();

        // Comprobar si el usuario tiene un perfil
        if (!$client->profile) {
            // Si no tiene un perfil, crea uno
            $profile = new ClientProfile($profileData);
            $client->profile()->save($profile);
        } else {
            // Si ya tiene un perfil, actualiza los datos
            DB::beginTransaction();
            try {
                $client->profile()->update($profileData);
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                return response()->json(['error' => 'Error al actualizar el perfil', 'errors' => $th->getMessage()], 500);
            }
        }
    
        return response()->json(['message' => 'Perfil actualizado exitosamente', 'cliente' => $client], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        //
    }
}
