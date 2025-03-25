<?php

namespace App\Repositories;

use App\Interfaces\ClientInterface;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

class ClientRepository implements ClientInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    
    public function create(array $data): Client
    {
        return Client::create($data);
    }

    public function show()
    {
        return Client::paginate(10);
        // return User::all();
    }

    public function viewClient($id)
    {
        return Client::find($id);
    }

    public function update($clientRequest)
    {
        $client = Client::findOrFail($clientRequest->id);

        if ($clientRequest->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($client->image !== 'null' && Storage::disk('public')->exists($client->image)) {
                Storage::disk('public')->delete($client->image);
            }

            $image = $clientRequest->file('image');

            $image_ext = $image->getClientOriginalExtension();
            $image_name = 'Client_' . time() . '.' . $image_ext;
            $client->image = $image->storeAs('client', $image_name, 'public');
        }

        $client->user_id_update = auth()->id();
        $client->firstname = $clientRequest->input('firstname');
        $client->lastname = $clientRequest->input('lastname');
        $client->email = $clientRequest->input('email');
        $client->tel = $clientRequest->input('tel');
        $client->address = $clientRequest->input('address');
        $client->sex = $clientRequest->input('sex') === "Selectionner" ? null : ($clientRequest->input('sex') === 'Homme' ? true : false);

        // $client->updated_at = now();
        
        $client->save();

        return $client;
    }

    public function destroy($id)
    {
        return Client::find($id);
    }
}
