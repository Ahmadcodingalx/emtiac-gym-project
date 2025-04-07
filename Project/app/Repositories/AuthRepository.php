<?php

namespace App\Repositories;

use App\Interfaces\AuthInterface;
use App\Models\Abonnement;
use Carbon\Carbon;

class AuthRepository implements AuthInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function update_ab_status()
    {
        // On récupère la date actuelle
        // $today = Carbon::today();

        // // On récupère tous les abonnements avec un statut "actif" et dont la date de fin est passée
        // $abonnements = Abonnement::where('status', 'attente')  // Seulement les abonnements "actifs"
        //     ->whereDate('end_date', '>', $today)  // Date de fin inférieure à aujourd'hui
        //     ->get();  // Récupération de ces abonnements

        // // Pour chaque abonnement expiré, on change son statut à "terminé"
        // foreach ($abonnements as $abonnement) {
        //     $abonnement->status = 'suspendu';  // Mise à jour du statut
        //     $abonnement->save();  // Sauvegarde les modifications dans la base de données
        // }
    }
}
