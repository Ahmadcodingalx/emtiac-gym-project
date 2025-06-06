<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Interfaces\ClientInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClientController extends Controller
{

    private ClientInterface $clientInterface;

    public function __construct(ClientInterface $clientInterface)
    {
        $this->clientInterface = $clientInterface;
    }


    public function addClient()
    {
        return view('client/addClient');
    }


    public function clientList()
    {
        $clients = $this->clientInterface->show();

        return view('client/clientList', compact('clients'));
    }

    public function viewClient($id)
    {

        $client = $this->clientInterface->viewClient($id);

        return view('client/viewClient', compact('client'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(ClientRequest $clientRequest)
    {

        $filePath = 'defaults/profile.png';

        if ($clientRequest->hasFile('image')) {

            $image = $clientRequest->file('image');

            $image_ext = $image->getClientOriginalExtension();
            $image_name = 'Client_' . time() . '.' . $image_ext;
            $filePath = $image->storeAs('clients', $image_name, 'public');
        }

        // Validation des données
        $data = [
            'user_id_create' => auth()->id(),
            'firstname' => Str::title($clientRequest->firstname),
            'lastname' => Str::upper($clientRequest->lastname),
            'email' => $clientRequest->email,
            'image' => $filePath,
            'tel' => $clientRequest->tel,
            'address' => $clientRequest->address,
            'identifiant' => strtoupper(substr($clientRequest->firstname, 0, 2))
                . strtoupper(substr($clientRequest->lastname, 0, 2))
                . '_'
                . rand(100, 999),
            'sex' => $clientRequest->sex === "Selectionner" ? null : ($clientRequest->sex === 'Homme' ? true : false),
        ];

        DB::beginTransaction();

        try {
            $client = $this->clientInterface->create($data);

            if ($client) {  // Vérification si l'utilisateur a bien été créé
                DB::commit();
                return back()->with('success', 'Client créé avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'La création du client a échoué.']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => 'Une erreur est survenue lors de la création de l’utilisateur.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $clientRequest)
    {
        //
        DB::beginTransaction();
        $id = 0;

        try {
            $client = $this->clientInterface->update($clientRequest);

            if ($client) {  // Vérification si l'utilisateur a bien été modifier
                DB::commit();
                return back()->with('success', 'Oppération réussie !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Echec de l\'oppération.']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'oppération']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->input('id');

        $client = $this->clientInterface->destroy($id);
        $client->delete();

        return back()->with('success', 'Oppération réussie !');
    }

      
    public function clientSearch(Request $request)
    {
        $query = $request->get('q');
        $clients = $this->clientInterface->clientSearch($query);

        return view('client.clientTable', compact('clients'))->render();
        
    }
    
    public function clientSearchZero(Request $request)
    {

        $query = $request->get('q');
        $clients = $this->clientInterface->show();

        return view('client.clientTable', compact('clients'))->render();
    }
}
