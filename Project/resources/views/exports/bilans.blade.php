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
    <h2>Bilan du mois de {{ $month }}</h2>
    <p>Total des revenus : {{ number_format($incomes, 0, ',', ' ') }} FCFA</p>
    <p>Total des dépenses : {{ number_format($expenses, 0, ',', ' ') }} FCFA</p>

    <h4>Détails :</h4>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $t)
                <tr>
                    <td>{{ $t->date }}</td>
                    <td>{{ $t->reason }}</td>
                    <td>{{ number_format($t->amount, 0, ',', ' ') }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
