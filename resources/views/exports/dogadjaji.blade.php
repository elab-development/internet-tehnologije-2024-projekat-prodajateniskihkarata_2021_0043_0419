<!DOCTYPE html>
<html>
<head>
    <title>Dogadjaji</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dogadjaji</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Lokacija</th>
                    <th>Opis</th>
                    <th>Status</th>
                    <th>Datum Registracije</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dogadjaji as $dogadjaj)
                <tr>
                    <td>{{ $dogadjaj->id }}</td>
                    <td>{{ $dogadjaj->ime_dogadjaja }}</td>
                    <td>{{ $dogadjaj->lokacija }}</td>
                    <td>{{ $dogadjaj->opis }}</td>
                    <td>{{ $dogadjaj->status }}</td>
                    <td>{{ $dogadjaj->datum_registracije }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>