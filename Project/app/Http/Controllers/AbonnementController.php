<?php

namespace App\Http\Controllers;

use App\Interfaces\AbonnementInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbonnementController extends Controller
{
    private AbonnementInterface $abonnementInterface;

    public function __construct(AbonnementInterface $abonnementInterface)
    {
        $this->abonnementInterface = $abonnementInterface;
    }

    public function addAb()
    {

        $allData = $this->abonnementInterface->addAb();
        
        $clients = $allData['clientData'];
        $types = $allData['typeData'];
        $services = $allData['serviceData'];

        return view('abonnements/addAbonnement', compact('clients', 'types', 'services'));
    }

    
    public function adList()
    {
        $abonnements = $this->abonnementInterface->show();

        return view('abonnements/abonnementsList', compact('abonnements'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'type' => 'required',
            'start_date' => 'required',
        ]);

        $data = [
            'client_id' => $request->client,
            'user_create_id' => auth()->id(),
            'type_id' => $request->type,
            'status' => 'attente',
            'service_id' => $request->service,
            'start_date' => $request->start_date,
            'end_date' => '',
            'price' => $request->price,
            'transaction_id' => '',
            'remark' => $request->remark,
        ];

        DB::beginTransaction();

        try {

            $abb = $this->abonnementInterface->store($data);

            if ($abb) {
                DB::commit();
                return back()->with('success', 'Oppération éffectuée avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Oppération a échoué.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de la création de l’abonnement.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $ab = $this->abonnementInterface->viewAb($id);

        $allData = $this->abonnementInterface->addAb();

        $clients = $allData['clientData'];
        $types = $allData['typeData'];
        $services = $allData['serviceData'];

        return view('abonnements/viewAbonnement', compact('ab', 'clients', 'types', 'services'));
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
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();

        try {
            $ab = $this->abonnementInterface->update($request, $id);
            
            if ($ab) {  // Vérification si l'abonnement a bien été modifier
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
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de l\'oppération']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::beginTransaction();
        try {
            $abb = $this->abonnementInterface->destroy($request->id);

            if ($abb) {
                $abb->delete();
                DB::commit();
                return back()->with('success', 'Oppération éffectuée avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Oppération a échoué.']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de la création de l’abonnement.']);
        }
    }

    public function updateStatus($id, $status)
    {
        DB::beginTransaction();
        try {
            $abb = $this->abonnementInterface->updateStatus($status, $id);

            if ($abb) {
                DB::commit();
                return back()->with('success', 'Oppération éffectuée avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Oppération a échoué.']);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de la création de l’abonnement.']);
        }
    }














    public function show_service()
    {
        $service = $this->abonnementInterface->show_service();

        return view('service.service', compact('service'));
    }

    public function create_service(Request $request)
    {
        // Validation des données
        $data = [
            'name' => $request->name,
            'description' => $request->desc,
        ];

        DB::beginTransaction();

        try {
            $service = $this->abonnementInterface->create_service($data);
            
            if ($service) {  // Vérification si l'utilisateur a bien été créé
                DB::commit();
                return back()->with('success', 'Service créé avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'La création du service a échoué.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return $th;
            // return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du cours.']);
        }
    }

    public function destroy_service(Request $request)
    {
        $id = $request->input('id');

        $service = $this->abonnementInterface->destroy_service($id);
        $service->delete();

        return back()->with('success', 'Oppération réussie !');
    }

    public function update_service(Request $request)
    {

        DB::beginTransaction();
        $id = 0;

        try {
            $service = $this->abonnementInterface->update_service($request, $id);
            
            if ($service) {  // Vérification si l'utilisateur a bien été modifier
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
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de l\'oppération']);
        }
    }


    public function show_type()
    {
        $types = $this->abonnementInterface->show_type();

        return view('type.type', compact('types'));
    }

    public function create_type(Request $request)
    {
        // Validation des données
        $data = [
            'name' => $request->name,
            'number' => $request->number,
            'type' => $request->type,
            'description' => $request->desc,
            'amount' => $request->amount,
        ];

        DB::beginTransaction();

        try {
            $type = $this->abonnementInterface->create_type($data);
            
            if ($type) {  // Vérification si l'utilisateur a bien été créé
                DB::commit();
                return back()->with('success', 'Type d\'abonnement créé avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'La création du Type d\'abonnement a échoué.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            // return $th;
            return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de la création du cours.']);
        }
    }

    public function destroy_type(Request $request)
    {
        $id = $request->input('id');

        $type = $this->abonnementInterface->destroy_type($id);
        $type->delete();

        return back()->with('success', 'Oppération réussie !');
    }

    public function update_type(Request $request)
    {

        DB::beginTransaction();
        $id = 0;

        try {
            $type = $this->abonnementInterface->update_type($request, $id);
            
            if ($type) {  // Vérification si l'utilisateur a bien été modifier
                DB::commit();
                return back()->with('success', 'Oppération réussie !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'Echec de l\'oppération.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return $th;
            // return back()->withErrors(['error' => $th . 'Une erreur est survenue lors de l\'oppération']);
        }
    }
}
