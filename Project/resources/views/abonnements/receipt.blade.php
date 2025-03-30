<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reçu d'Abonnement</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; padding: 20px; border: 1px solid #000; }
        .header { text-align: center; font-size: 20px; font-weight: bold; }
        .details { margin-top: 20px; }
        .details p { margin: 5px 0; }
        .footer { text-align: center; margin-top: 20px; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">
            Gym H
        </div>
        <div class="header">
            Reçu d'Abonnement N° {{ $ab->transaction_id }}
        </div>

        <div class="details">
            <p><strong>Date et heure:</strong> {{ now()->format('d/m/Y') }}</p>
            @if ($ab->if_group)
                <p><strong>Nombre de personnes:</strong> {{ $ab->groupes->count() }} </p>
            @else
                <p><strong>Nom et prénom:</strong> {{ $ab->client->firstname ?? $ab->firstname }} {{ $ab->client->lastname ?? $ab->lastname }}</p>
            @endif
            <p><strong>Type d'abonnement:</strong> {{ $ab->type->name }} à {{ $ab->type->amount }} fcfa    
                @if ($ab->if_group)
                    --------- <span style="font-size: 15px" class="text-neutral-600">( en groupe ) </span>
                @endif
            </p>
            <p><strong>Payé:</strong> {{ number_format($ab->price ?? $ab->type->amount, 2) }} fcfa</p>
            @if (!$ab->if_all_pay)
                <p><strong>Reste:</strong> {{ number_format($ab->rest, 2) }} fcfa --------- <span style="font-size: 15px" class="text-neutral-600">( à terminer avant le {{ $ab->end_pay_date }} ) </span></p>
            @endif
            <p><strong>Date de début:</strong> {{ $ab->start_date }}</p>
            <p><strong>Date de fin:</strong> {{ $ab->end_date }}</p>
            {{-- <p><strong>Nombre de séances restantes:</strong> {{ $ab->type->name ?? 'N/A' }}</p> --}}
            <p><strong>mode de paiemant:</strong> Espèces</p>
            <p><strong>Service:</strong> {{ $ab->service->name ?? 'Aucun' }}</p>
            <p><strong>Responsable de l'enregistrement:</strong> {{ $ab->createdBy->firstname ?? 'Aucun' }}
                {{ $ab->createdBy->lastname ?? '' }}</p>
            <p><strong>Adresse:</strong> Lomé</p>
            <p><strong>Contact:</strong> +228 96891550 / moroumamam53@gmail.com</p>
        </div>

        <div class="footer">
            Condition d'utilisation <br>
            -Ce ticket est personnel et non transférable <br>
            -Présentation obligatoire à l'entrée <br>
            -Valable jusqu'à expiration de l'abonnement <br><br>
            Merci pour votre confiance ! 
        </div>
    </div>
</body>
</html>
