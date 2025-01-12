<!DOCTYPE html>
<html>
<head>
    <title>PDF Export</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>PDF Export</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Email</th>
                <th>Kreirano</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->ime }}</td>
                    <td>{{ $row->email }}</td>
                    <td>{{ $row->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
