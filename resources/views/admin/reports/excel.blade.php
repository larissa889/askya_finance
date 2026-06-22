<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport ASKYA Finance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .stats {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ASKYA Finance - Rapport Excel</h1>
        <p>Période: {{ $period }} | Du {{ $startDate }} au {{ $endDate }}</p>
    </div>

    <div class="stats">
        <h3>Statistiques</h3>
        <p>Total transactions: {{ $reportData['statistics']['total_transactions'] }}</p>
        <p>Montant total: {{ number_format($reportData['statistics']['total_amount'], 0, ',', ' ') }} FCFA</p>
        <p>Revenu total: {{ number_format($reportData['statistics']['total_revenue'], 0, ',', ' ') }} FCFA</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>N° Transaction</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Client</th>
                <th>Téléphone</th>
                <th>Service</th>
                <th>Opération</th>
                <th>Montant</th>
                <th>Frais</th>
                <th>Total</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['transactions'] as $transaction)
            <tr>
                <td>{{ $transaction->transaction_number }}</td>
                <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                <td>{{ $transaction->transaction_time }}</td>
                <td>{{ $transaction->client_name }}</td>
                <td>{{ $transaction->client_phone }}</td>
                <td>{{ $transaction->service->name }}</td>
                <td>{{ $transaction->operationType->name }}</td>
                <td>{{ number_format($transaction->amount, 0, ',', ' ') }}</td>
                <td>{{ number_format($transaction->fees, 0, ',', ' ') }}</td>
                <td>{{ number_format($transaction->total, 0, ',', ' ') }}</td>
                <td>{{ ucfirst($transaction->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
