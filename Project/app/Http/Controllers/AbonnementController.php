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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
