<?php

namespace App\Http\Controllers;

use App\Interfaces\CoursInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursController extends Controller
{
    //
    private CoursInterface $coursInterface;

    public function __construct(CoursInterface $cours_interface)
    {
        $this->coursInterface = $cours_interface;
    }

    public function show()
    {
        $cours = $this->coursInterface->show();

        return view('cours.cours', compact('cours'));
    }

    public function create(Request $request)
    {
        // Validation des données
        $data = [
            'name' => $request->name,
            'description' => $request->desc,
            'coach_id' => $request->coach_id === 'Selectionner un coach' ? null : $request->coach_id,
        ];

        DB::beginTransaction();

        try {
            $cours = $this->coursInterface->create($data);
            
            if ($cours) {  // Vérification si l'utilisateur a bien été créé
                DB::commit();
                return back()->with('success', 'Cours créé avec succès !');
            } else {
                DB::rollback();
                return back()->withErrors(['error' => 'La création du cours a échoué.']);
            }

        } catch (\Throwable $th) {
            DB::rollback();
            //throw $th;
            return $th;
            // return back()->withErrors(['error' => 'Une erreur est survenue lors de la création du cours.']);
        }
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');

        $user = $this->coursInterface->destroy($id);
        $user->delete();

        return back()->with('success', 'Oppération réussie !');
    }

    public function update(Request $request)
    {

        DB::beginTransaction();
        $id = 0;

        try {
            $cours = $this->coursInterface->update($request, $id);
            
            if ($cours) {  // Vérification si l'utilisateur a bien été modifier
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
}
