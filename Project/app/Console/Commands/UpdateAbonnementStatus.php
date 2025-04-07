<?php

namespace App\Console\Commands;

use App\Models\Abonnement;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateAbonnementStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // Signature de la commande, c'est ce qui sera exécuté en ligne de commande
    protected $signature = 'abonnement:update-status';
    
    // Description de la commande (affichée avec `php artisan list`)
    protected $description = 'Met à jour le statut des abonnements suspendu';

    public function handle()
    {
        // On récupère la date actuelle
        $today = Carbon::today(); // Date du jour
        $tomorrow = Carbon::tomorrow(); // Date de demain

        // Trouver les abonnements qui débute demain
        $startingSubscriptions = Abonnement::where('status', 'attente')
                                                ->whereDate('start_date', '<', $tomorrow)->get();

        // Trouver les abonnements qui expirent aujourd'hui
        $startSubscriptions = Abonnement::where('status', 'attente')
                                                ->whereDate('start_date', '<', $today)->get();
        
        foreach ($startingSubscriptions as $subscription) {
            // Exemple : Modifier le statut de l'abonnement ou envoyer un e-mail

            // Exemple d'envoi de notification
            // Notification::send($subscription->user, new SubscriptionExpiringNotification($subscription));
        }
        foreach ($startSubscriptions as $subscription) {
            // Exemple : Modifier le statut de l'abonnement ou envoyer un e-mail
            $subscription->update(['status' => 'actif']);

            // Exemple d'envoi de notification
            // Notification::send($subscription->user, new SubscriptionExpiringNotification($subscription));

            $this->info("L'abonnement ID {$subscription->id} expire bientôt.");
        }


        // Trouver les abonnements qui expirent demain
        $expiringSubscriptions = Abonnement::whereIn('status', ['actif', 'suspendu', 'attente'])
                                                ->whereDate('end_date', '<', $tomorrow)->get();

        // Trouver les abonnements qui expirent aujourd'hui
        $expireSubscriptions = Abonnement::whereIn('status', ['actif', 'suspendu', 'attente'])
                                                ->whereDate('end_date', '<', $today)->get();

        foreach ($expireSubscriptions as $subscription) {
            // Exemple : Modifier le statut de l'abonnement ou envoyer un e-mail
            $subscription->update(['status' => 'expiré']);

            // Exemple d'envoi de notification
            // Notification::send($subscription->user, new SubscriptionExpiringNotification($subscription));

            $this->info("L'abonnement ID {$subscription->id} expire bientôt.");
        }

        
        

        // On récupère tous les abonnements avec un statut "actif" et dont la date de fin de payement est passée
        $abonnements = Abonnement::where('status', 'actif')
            ->whereDate('end_pay_date', '<', $today)  // Date de fin inférieure à aujourd'hui
            ->get();  // Récupération de ces abonnements

        // Pour chaque abonnement expiré, on change son statut à "terminé"
        foreach ($abonnements as $abonnement) {
            $abonnement->status = 'suspendu';  // Mise à jour du statut
            $abonnement->save();  // Sauvegarde les modifications dans la base de données
            $this->info(count($abonnements) . ' abonnements mis à jour.');
        }

        // On affiche un message dans la console pour indiquer combien d'abonnements ont été mis à jour
        $this->info('Vérification des abonnements terminée.');
    }
}
