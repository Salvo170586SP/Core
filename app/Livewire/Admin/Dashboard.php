<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $teachers = User::role('istruttore')->latest()->get();
        $students = User::role('allievo')->latest()->get();
        $courses = Course::where('type', 'all')->latest()->get();
        $evening_courses = Course::where('type', 'evening')->latest()->get();


        
        //CARD TESSERATI
        // Conteggio progressivo dei tesseramenti dal 2024 ad oggi 
        $startYear = 2024;
        $currentYear = Carbon::now()->year;

        $labels = [];
        $data = [];
        $totaleProgressivo = 0;

        // Cicla attraverso gli anni dal 2024 fino all'anno corrente
        for ($year = $startYear; $year <= $currentYear; $year++) {
            $labels[] = (string) $year;

            // Conta i tesseramenti attivi creati in questo anno
            $badge_actives = DB::table('course_student')
                ->where('is_active', true)
                ->whereYear('created_at', $year)
                ->count();

            $totaleProgressivo += $badge_actives;
            $data[] = $totaleProgressivo;
        }




        //CARD CORSI
        // Definisci tutti gli status possibili
        $allStatus = ['start', 'pending', 'cancel', 'closed'];

        // Conta i corsi raggruppati per status
        $corsiPerStatus = DB::table('courses')
            ->select('status', DB::raw('COUNT(*) as totale'))
            ->groupBy('status')
            ->pluck('totale', 'status');

        // Prepara i dati per il grafico
        $labelsCourses = [];
        $dataCourses = [];
        $backgroundColors = [];
        $borderColors = [];

        // Mappa dei colori per ogni status
        $colorMap = [
            'start' => ['bg' => 'rgba(75, 192, 192, 0.6)', 'border' => 'rgba(75, 192, 192, 1)'],
            'pending' => ['bg' => 'rgba(255, 206, 86, 0.6)', 'border' => 'rgba(255, 206, 86, 1)'],
            'cancel' => ['bg' => 'rgba(255, 159, 64, 0.6)', 'border' => 'rgba(255, 159, 64, 1)'],
            'closed' => ['bg' => 'rgba(255, 99, 132, 0.6)', 'border' => 'rgba(255, 99, 132, 1)'],
        ];

        // Cicla su tutti gli status e assegna i valori (anche 0)
        foreach ($allStatus as $status) {
            $labelsCourses[] = $status;
            $dataCourses[] = $corsiPerStatus[$status] ?? 0; // Se non esiste, metti 0
            $backgroundColors[] = $colorMap[$status]['bg'];
            $borderColors[] = $colorMap[$status]['border'];
        }

        return view('livewire.admin.dashboard', compact(
            'teachers',
            'students',
            'courses',
            'evening_courses',
            'badge_actives',
            'labels',
            'data',

            'labelsCourses',
            'dataCourses',
            'backgroundColors',
            'borderColors'
        ));
    }
}
