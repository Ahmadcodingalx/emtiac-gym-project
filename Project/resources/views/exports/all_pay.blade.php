<!DOCTYPE html>
<html>
<head>
    <title>Bilan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
    </style>
</head>
<body>
    <h2>Mois de {{ $month }}</h2>
    {{-- <p>Total des revenus : {{ number_format($revenus, 0, ',', ' ') }} FCFA</p>
    <p>Total des dépenses : {{ number_format($depenses, 0, ',', ' ') }} FCFA</p> --}}

    <h4>Payements tèrminé :</h4>
    <table>
        <thead>
            <tr>
                <th>Date limite</th>
                <th>Client</th>
                <th>Montant restant</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rest as $r)
                <tr>
                    <td>{{ $r->end_pay_date }}</td>
                    <td>
                        {{ $r->client->firstname ?? $r->firstname }}
                        {{ $r->client->lastname ?? $r->lastname }}
                    </td>
                    <td>{{ number_format($r->rest, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
