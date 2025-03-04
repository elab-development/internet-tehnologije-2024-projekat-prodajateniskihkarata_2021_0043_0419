<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dogadjaj;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DogadjajSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Dogadjaj::factory(1)->create();


        // DB::statement('SET FOREIGN_KEY_CHECKS=0;'); // Isključivanje provere stranih ključeva
        // DB::table('dogadjajs')->truncate(); // Briše sve podatke iz tabele bez problema sa FK
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;'); // Ponovno uključivanje FK provera

        $mecevi = [
            [
                'ime_dogadjaja' => 'Final match',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Final match',
                'status' => 'scheduled',
                'datum_registracije' => Carbon::create(2025, 2, 15, 18, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Semi final match One',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Semi final match. Medjedovic H. is awaiting for better from duel Djere L. Marozsan F.',
                'status' => 'scheduled',
                'datum_registracije' => Carbon::create(2025, 2, 14, 16, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Semi final match Two',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => "Semi final match. Lehecka J. is awaiting for better from duel O'Connell C. Shapovalov D.",
                'status' => 'scheduled',
                'datum_registracije' => Carbon::create(2025, 2, 14, 16, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Djere L. VS Marozsan F. (Quarterfinal)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Quarterfinal match between Djere L. VS Marozsan F.',
                'status' => 'scheduled',
                'datum_registracije' => Carbon::create(2025, 2, 13, 14, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'O\'Connell C. VS Shapovalov D. (Quarterfinal)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Quarterfinal match between O\'Connell C. VS Shapovalov D.',
                'status' => 'scheduled',
                'datum_registracije' => Carbon::create(2025, 2, 13, 14, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Cerundolo F. VS Medjedovic H. (Quarterfinal)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Quarterfinal match between Cerundolo F. VS Medjedovic H., finished with result (0-2) (4-6, 2-6). Medjedovic H. secured a strong win. comfortably.',
                'status' => 'scheduled',
                'datum_registracije' => Carbon::create(2025, 2, 13, 16, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Klein L. VS Lehecka J. (Quarterfinal)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Quarterfinal match between Klein L. VS Lehecka J., finished with result (1-2) (6-3, 3-6, 6-7). Lehecka J. won after a tough battle.',
                'status' => 'scheduled',
                'datum_registracije' => Carbon::create(2025, 2, 13, 17, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Ajdukovic D. VS Djere L. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Round of 16 match between Ajdukovic D. VS Djere L., finished with result (0-2) (68-710). Ajdukovic D. fought hard, but Djere L. took the match in straight sets.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 14, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Marozsan F. VS Lajovic D. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Round of 16 match between Marozsan F. VS Lajovic D., finished with result (2-0) (6-3, 6-5). Marozsan F. dominated the match.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 16, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Shapovalov D. VS Borges N. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Round of 16 match between Shapovalov D. VS Borges N., finished with result (2-0) (6-2, 6-2). Shapovalov D. won convincingly.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 17, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Altmaier D. VS O\'Connell C. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Round of 16 match between Altmaier D. VS O\'Connell C., finished with result (2-0) (6-4, 6-4). Altmaier D. secured a solid win.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 14, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Cerundolo F. VS Safiullin R. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Round of 16 match between Cerundolo F. VS Safiullin R., finished with result (2-0) (6-4, 6-4). Cerundolo F. claimed victory in straight sets.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 15, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Kovacevic A. VS Medjedovic H. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Round of 16 match between Kovacevic A. VS Medjedovic H., finished with result (0-2) (5-7, 6-7). Medjedovic H. claimed victory.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 16, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Etcheverry T. M. VS Klein L. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Round of 16 match between Etcheverry T. M. VS Klein L., finished with result (0-2) (4-6, 6-7). Klein L. won in straight sets.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 17, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Čilić M. VS Lehecka J. (Round of 16)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Round of 16 match between Čilić M. VS Lehecka J., finished with result (0-2) (4-6, 4-6). Lehecka J. outplayed Čilić M.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 18, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Djere L. VS Wawrinka S. (Group Match)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Group Match between Djere L. VS Wawrinka S., finished with result (2-0) (6-4, 6-4). Djere L. secured a win.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 18, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Safiullin R. VS Fognini F. (Group match)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Group match between Safiullin R. VS Fognini F., finished with result 2-0 (6-3, 6-4). Safiullin R. won the match in straight sets.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 19, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Kecmanovic M. VS O\'Connell C. (Group match)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Group match between Kecmanovic M. VS O\'Connell C., finished with result 0-2 (1-6, 3-6). O\'Connell C. dominated the match.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 11, 19, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Fucsovics M. VS Shapovalov D. (Group match)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Group match between Fucsovics M. VS Shapovalov D., finished with result 1-2 (7-6, 4-6, 3-6). Shapovalov D. came back after losing the first set.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 10, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Lajovic D. VS Navone M. (Group match)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Group match between Lajovic D. VS Navone M., finished with result 2-0 (6-0, 6-3). Lajovic D. won convincingly.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 10, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Duckworth J. VS Klein L. (Group match)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Group match between Duckworth J. VS Klein L., finished with result 0-2 (4-6, 2-6). Klein L. won in straight sets.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Djuric B. VS Kovacevic A. (Group match)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Group match between Djuric B. VS Kovacevic A., finished with result 0-2 (2-6, 3-6). Kovacevic A. won comfortably.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Etcheverry T. M. VS Kotov P. (Group match)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Group match between Etcheverry T. M. VS Kotov P., finished with result 2-0 (6-3, 6-4). Etcheverry T. M. won in straight sets.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Čilić M. VS Muller A. (Group match)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Group match between Čilić M. VS Muller A., finished with result 2-0 (7-6, 6-3). Čilić M. won after a tight first set.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Darderi L. VS Altmaier D. (Group match)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Group match between Darderi L. VS Altmaier D., finished with result 0-2 (3-6, 4-6). Altmaier D. won in straight sets.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Medjedovic H. VS Nakashima B. (Group match)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Group match between Medjedovic H. VS Nakashima B., finished with result 2-1 (7-6, 1-6, 6-3). Medjedovic H. won after a tough match.',
                'status' => 'played ',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Qualifications (Match 1)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Qualification match',
                'status' => 'canceled',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Qualifications (Match 2)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Qualification match',
                'status' => 'canceled',
                'datum_registracije' => Carbon::create(2025, 2, 12, 11, 30, 0),
            ],
            [
                'ime_dogadjaja' => 'Qualifications (Match 3)',
                'lokacija' => 'Belgrade Arena Court 1',
                'opis' => 'Qualification match',
                'status' => 'canceled',
                'datum_registracije' => Carbon::create(2025, 2, 12, 12, 0, 0),
            ],
            [
                'ime_dogadjaja' => 'Qualifications (Match 4)',
                'lokacija' => 'Belgrade Arena Court 2',
                'opis' => 'Qualification match',
                'status' => 'canceled',
                'datum_registracije' => Carbon::create(2025, 2, 12, 12, 30, 0),
            ],
        ];

        foreach ($mecevi as $mec) {
            Dogadjaj::create([
                'ime_dogadjaja' => $mec['ime_dogadjaja'],
                'lokacija' => $mec['lokacija'],
                'opis' => $mec['opis'],
                'status' => $mec['status'],
                'datum_registracije' => $mec['datum_registracije'],
            ]);

        }
    }
   
}
