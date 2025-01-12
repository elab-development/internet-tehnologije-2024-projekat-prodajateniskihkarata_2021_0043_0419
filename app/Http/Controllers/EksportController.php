<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dogadjaj;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use App\Exports\DogadjajExport;

use App\Models\Korisnik; // Model za podatke
use Illuminate\Support\Facades\Response;
use League\Csv\Writer;
use Dompdf\Dompdf;



class EksportController extends Controller
{
    // Eksport podataka u CSV formatu
    public function eksportCSV()
    {
        $dogadjaji = Dogadjaj::all();
        $csv = Writer::createFromString('');

        // Dodajte zaglavlja kolona
        $csv->insertOne(['ID', 'Naziv', 'Lokacija', 'Opis', 'Status', 'Datum Registracije']);

        // Dodajte podatke o događajima
        foreach ($dogadjaji as $dogadjaj) {
            $csv->insertOne([
                $dogadjaj->id,
                $dogadjaj->ime_dogadjaja,
                $dogadjaj->lokacija,
                $dogadjaj->opis,
                $dogadjaj->status,
                $dogadjaj->datum_registracije,
            ]);
        }

        $csvContent = $csv->toString();

        return response($csvContent)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="dogadjaji.csv"');
    }

    // Eksport podataka u ICS formatu
    public function eksportICS()
    {
        $dogadjaji = Dogadjaj::all();
        $calendar = Calendar::create('Dogadjaji');

        foreach ($dogadjaji as $dogadjaj) {
            $event = Event::create($dogadjaj->ime_dogadjaja)
                ->description($dogadjaj->opis)
                ->address($dogadjaj->lokacija)
                ->startsAt(new \DateTime($dogadjaj->datum_registracije));
            $calendar->event($event);
        }

        return response($calendar->get())
            ->header('Content-Type', 'text/calendar')
            ->header('Content-Disposition', 'attachment; filename="dogadjaji.ics"');
    }

    // Eksport podataka u PDF formatu
    public function eksportPDF()
    {
        $dogadjaji = Dogadjaj::all();
        $html = view('exports.dogadjaji', compact('dogadjaji'))->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $dompdf->stream('dogadjaji.pdf');
    }








    // public function exportCsv()
    // {
    //     $fileName = 'data_export.csv';
    //     $data = Korisnik::all();

    //     $headers = [
    //         "Content-type" => "text/csv",
    //         "Content-Disposition" => "attachment; filename=$fileName",
    //         "Pragma" => "no-cache",
    //         "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
    //         "Expires" => "0"
    //     ];

    //     $columns = ['ID', 'Ime', 'Email', 'Kreirano'];

    //     $callback = function () use ($data, $columns) {
    //         $file = fopen('php://output', 'w');
    //         fputcsv($file, $columns);

    //         foreach ($data as $row) {
    //             fputcsv($file, [
    //                 $row->id,
    //                 $row->ime,
    //                 $row->email,
    //                 $row->created_at,
    //             ]);
    //         }

    //         fclose($file);
    //     };

    //     return response()->stream($callback, 200, $headers);
    // }

    // public function exportPdf()
    // {
    //     $data = Korisnik::all();
    //     $pdf = Pdf::loadView('exports.pdf', ['data' => $data]);

    //     return $pdf->download('data_export.pdf');
    // }

    // public function exportIcs()
    // {
    //     $fileName = 'event.ics';
    //     $event = [
    //         'summary' => 'Primerni događaj',
    //         'start' => now()->addDay()->format('Ymd\THis'),
    //         'end' => now()->addDay()->addHour()->format('Ymd\THis'),
    //         'description' => 'Opis događaja',
    //         'location' => 'Online',
    //     ];

    //     $content = "BEGIN:VCALENDAR\r\n" .
    //                "VERSION:2.0\r\n" .
    //                "BEGIN:VEVENT\r\n" .
    //                "SUMMARY:{$event['summary']}\r\n" .
    //                "DTSTART:{$event['start']}\r\n" .
    //                "DTEND:{$event['end']}\r\n" .
    //                "DESCRIPTION:{$event['description']}\r\n" .
    //                "LOCATION:{$event['location']}\r\n" .
    //                "END:VEVENT\r\n" .
    //                "END:VCALENDAR\r\n";

    //     return response($content)
    //         ->header('Content-Type', 'text/calendar')
    //         ->header('Content-Disposition', "attachment; filename=$fileName");
    // }
}
