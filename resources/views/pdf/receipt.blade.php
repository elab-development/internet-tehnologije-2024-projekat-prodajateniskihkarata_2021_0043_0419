<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Kartica Plaćanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .receipt-header {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .receipt-details {
            margin-bottom: 20px;
        }
        .receipt-details table {
            width: 100%;
            border-collapse: collapse;
        }
        .receipt-details table, .receipt-details th, .receipt-details td {
            border: 1px solid #000;
        }
        .receipt-details th, .receipt-details td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="receipt-header">
        <h2>Potvrda o Plaćanju</h2>
    </div>

    <div class="receipt-details">
        <h3>Podaci o transakciji:</h3>
        <table>
            <tr>
                <th>Datum transakcije</th>
                <td>{{ $placanje->datum_transakcije }}</td>
            </tr>
            <tr>
                <th>Iznos</th>
                <td>{{ number_format($placanje->iznos, 2) }} RSD</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $placanje->status_transakcije }}</td>
            </tr>
            <tr>
                <th>Tip plaćanja</th>
                <td>{{ $placanje->tip_placanja }}</td>
            </tr>
        </table>
    </div>

    <div class="receipt-footer" style="margin-top: 30px; text-align: center;">
        <p>Hvala na kupovini!</p>
    </div>
</body>
</html>
