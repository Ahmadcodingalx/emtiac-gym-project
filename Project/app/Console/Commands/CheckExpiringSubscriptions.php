<?php

namespace App\Console\Commands;

use App\Models\Abonnement;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiringSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expiring';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Vérifie les abonnements qui expirent bientôt et envoie une notification';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today(); // Date du jour
        $tomorrow = Carbon::tomorrow(); // Date de demain

        // Trouver les abonnements qui expirent aujourd'hui ou demain
        $expiringSubscriptions = Abonnement::whereIn('end_date', [$today, $tomorrow])->get();

        foreach ($expiringSubscriptions as $subscription) {
            // Exemple : Modifier le statut de l'abonnement ou envoyer un e-mail
            $subscription->update(['status' => 'expiring']);

            // Exemple d'envoi de notification
            // Notification::send($subscription->user, new SubscriptionExpiringNotification($subscription));

            $this->info("L'abonnement ID {$subscription->id} expire bientôt.");
        }

        $this->info('Vérification des abonnements terminée.');
    }
}
