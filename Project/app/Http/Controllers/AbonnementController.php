<?php

namespace App\Http\Controllers;

use App\Interfaces\AbonnementInterface;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function fetchAbonnements(Request $request)
    {
        $abonnements = $this->abonnementInterface->show();
        return response()->json($abonnements);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {}

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
            'payment_type' => 'required|in:total,partial',
        ]);

        $data = [
            'client_id' => $request->client,
            'user_create_id' => auth()->id(),
            'type_id' => $request->type,
            'status' => 'attente',
            'if_all_pay' => $request->payment_type === 'total' ? true : false,
            'if_group' => $request->if_group ? true : false,
            'rest' => null,
            'service_id' => $request->service,
            'start_date' => $request->start_date,
            'end_date' => '',
            'firstname' => $request->firstname ? Str::title($request->firstname) : null,
            'lastname' => $request->lastname ? Str::upper($request->lastname) : null,
            'tel' => $request->tel ? $request->tel : null,
            'price' => $request->price,
            'transaction_id' => '',
            'remark' => $request->remark,
        ];

        if (!$data['if_all_pay'] && !$data['price']) {
            return back()->withErrors(['error' => 'Veuillez renseigner le prix si le payement est partiel.']);
        }

        // Récupérer la date sélectionnée depuis l'input du formulaire
        $selectedDate = Carbon::parse($request->input('start_date'));

        // Obtenir la date d'aujourd'hui
        $today = Carbon::today(); // ou Carbon::now()->startOfDay()

        // Vérifier si la date est antérieure
        if ($selectedDate->lessThan($today)) {
            return back()->withErrors(['error' => 'La date sélectionnée ne doit pas antérieure à aujourd\'hui.']);
        }

        DB::beginTransaction();

        try {

            $abb = $this->abonnementInterface->store($data, 1);

            if ($abb) {
                $members = json_decode($request->members, true);

                if ($request->if_group == "1") {
                    foreach ($members as $member) {
                        $data2 = [
                            'abonnement_id' => $abb->id,
                            'firstname' => $member['firstname'],
                            'lastname' => $member['lastname'],
                            'tel' => $member['tel'],
                            'sex' => true,
                        ];

                        $this->abonnementInterface->store($data2, 2);
                    }
                }

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

    public function completeRest(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'amount' => 'required',
        ]);

        $data = [
            'abbId' => $request->id,
            'amount' => $request->amount
        ];

        DB::beginTransaction();
        try {
            $abb = $this->abonnementInterface->completeRest($data);

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

    // public function search(Request $request)
    // {
    //     $query = $this->abonnementInterface->search();

    //     if ($request->has('search')) {
    //         $search = $request->input('search');
    //         $query->where('code', 'LIKE', "%$search%")
    //             ->orWhere('status', 'LIKE', "%$search%")
    //             ->orWhere('start_date', 'LIKE', "%$search%");
    //     }

    //     $abonnements = $query->get(); // Pas de pagination ici pour AJAX

    //     return view('abonnements.partials.table', compact('abonnements'));
    // }














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


    public function previewPDF($id)
    {
        $abonnement = $this->abonnementInterface->viewAb($id);

        // Créer un PDF avec un format de papier plus petit, comme A6
        $pdf = Pdf::loadView('abonnements/receipt', compact('abonnement'))
            ->setPaper('a6', 'portrait'); // Ou 'letter' si tu préfères ce format
            // ->setPaper([0, 0, 500, 460]); // Ou 'letter' si tu préfères ce format

        return $pdf->stream('recu_' . $abonnement->id . '_' . $abonnement->transaction_id . '.pdf');
    }
}
