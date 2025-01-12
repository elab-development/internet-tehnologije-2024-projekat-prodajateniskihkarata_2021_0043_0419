<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pretraga Događaja</title>
</head>

<body>
    <h1>Pretraga Događaja</h1>

    <form action="{{ route('dogadjaji.pretraga') }}" method="GET">
        <label for="naziv">Naziv:</label>
        <input type="text" id="naziv" name="naziv" value="{{ old('naziv', $naziv) }}">

        <label for="lokacija">Lokacija:</label>
        <input type="text" id="lokacija" name="lokacija" value="{{ old('lokacija', $lokacija) }}">

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="">-- Svi Statusi --</option>
            <option value="zakazan" {{ old('status', $status) == 'zakazan' ? 'selected' : '' }}>Zakazan</option>
            <option value="odrzan" {{ old('status', $status) == 'odrzan' ? 'selected' : '' }}>Održan</option>
            <option value="otkazan" {{ old('status', $status) == 'otkazan' ? 'selected' : '' }}>Otkazan</option>
        </select>

        <button type="submit">Pretraži</button>
    </form>

    <h2>Rezultati Pretrage</h2>
    @if($dogadjaji->isEmpty())
        <p>Nema rezultata za zadate kriterijume pretrage.</p>
    @else
        <ul>
            @foreach($dogadjaji as $dogadjaj)
                <li>{{ $dogadjaj->ime_dogadjaja }} - {{ $dogadjaj->lokacija }} - {{ $dogadjaj->status }}</li>
            @endforeach
        </ul>
    @endif
</body>

</html>