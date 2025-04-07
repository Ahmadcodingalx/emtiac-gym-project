<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu d'Abonnement</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 95%; margin: auto; padding: 12px; border: 1px solid #000; }
        .header { text-align: center; font-size: 15px; font-weight: bold; }
        strong { font-size: 12px; font-weight: bold; }
        p { font-size: 12px; }
        .details { margin-top: 20px; }
        .details p { margin: 5px 0; }
        .footer { text-align: left; margin-top: 20px; font-size: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            Gym H
        </div>
        <div class="header">
            Reçu d'Abon. N° {{ $abonnement->transaction_id }}
        </div>

        <div class="details">
            <p><strong>Date et heure:</strong> {{ now()->format('d/m/Y') }}</p>
            @if ($abonnement->if_group)
                <p><strong>Nombre de personnes:</strong> {{ $abonnement->groupes->count() }} </p>
            @else
                <p><strong>Nom et prénom:</strong> {{ $abonnement->client->firstname ?? $abonnement->firstname }} {{ $abonnement->client->lastname ?? $abonnement->lastname }}</p>
            @endif
            <p><strong>Type d'abon. :</strong> {{ $abonnement->type->name }} à {{ $abonnement->type->amount }} F    
                @if ($abonnement->if_group)
                    - <span style="font-size: 12px" class="text-neutral-600">( en groupe ) </span>
                @endif
            </p>
            <p><strong>Payé:</strong> {{ number_format($abonnement->price ?? $abonnement->type->amount, 2) }} F</p>
            @if (!$abonnement->if_all_pay)
                <p><strong>Reste:</strong> {{ number_format($abonnement->rest, 2) }} F - <span style="font-size: 12px" class="text-neutral-600">( à payer avant le {{ $abonnement->end_pay_date }} ) </span></p>
            @endif
            <p><strong>Date de début:</strong> {{ $abonnement->start_date }}</p>
            <p><strong>Date de fin:</strong> {{ $abonnement->end_date }}</p>
            {{-- <p><strong>Nombre de séances restantes:</strong> {{ $abonnement->type->name ?? 'N/A' }}</p> --}}
            <p><strong>mode de paiemant:</strong> Espèces</p>
            <p><strong>Service:</strong> {{ $abonnement->service->name ?? 'Aucun' }}</p>
            <p><strong>Resp. de l'enreg. :</strong> {{ $abonnement->createdBy->firstname ?? 'Aucun' }}
                {{ $abonnement->createdBy->lastname ?? '' }}</p>
            <p><strong>Adresse:</strong> Lomé</p>
            <p><strong>Contact:</strong> +228 96891550 / moroumamam53@gmail.com</p>
        </div>

        <div class="footer">
            Condition d'utilisation: <br>
            Ce ticket est personnel et non transférable <br>
            Présentation obligatoire à l'entrée <br>
            Valable jusqu'à expiration de l'abonnement <br><br>
            Merci pour votre confiance ! 
        </div>
    </div>
</body>
</html>
