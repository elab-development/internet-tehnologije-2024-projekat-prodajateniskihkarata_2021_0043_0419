<?php

namespace App\Http\Controllers;

use App\Models\Dogadjaj;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DogadjajController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $dogadjaji = Cache::remember('dogadjaji', 60, function () use ($perPage) {
            return Dogadjaj::paginate($perPage); });
        return response()->json($dogadjaji, 200);
    }

    public function show($id)
    {
        $dogadjaj = Dogadjaj::find($id);
        if ($dogadjaj) {
            return response()->json($dogadjaj, 200);
        } else {
            return response()->json(['message' => 'Događaj nije pronađen'], 404);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'naziv_dogadjaja' => 'required|string',
            'lokacija' => 'required|string',
            'opis' => 'required|string',
            'datum_vreme' => 'required|date',
        ]);

        $dogadjaj = new Dogadjaj($request->all());
        $dogadjaj->save();

        return response()->json(['message' => 'Događaj je kreiran'], 201);
    }

    public function update(Request $request, $id)
    {
        $dogadjaj = Dogadjaj::find($id);

        if ($dogadjaj) {
            $dogadjaj->update($request->all());
            return response()->json(['message' => 'Događaj je ažuriran'], 200);
        } else {
            return response()->json(['message' => 'Događaj nije pronađen'], 404);
        }
    }

    public function destroy($id)
    {
        $dogadjaj = Dogadjaj::find($id);

        if ($dogadjaj) {
            $dogadjaj->delete();
            return response()->json(['message' => 'Događaj je obrisan'], 200);
        } else {
            return response()->json(['message' => 'Događaj nije pronađen'], 404);
        }
    }

    public function exportCsv()
{
    $dogadjaji = Dogadjaj::all();
    $csvExporter = new \Laracsv\Export();
    $csv = $csvExporter->build($dogadjaji, ['naziv_dogadjaja', 'lokacija', 'datum_vreme'])->getCsv();

    return response($csv)->header('Content-Type', 'text/csv');
}

}
