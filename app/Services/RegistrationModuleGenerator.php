<?php

namespace App\Services;

use App\Models\Document;
use App\Models\User;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class RegistrationModuleGenerator
{
    public function generate(User $student, array $overrides = []): Document
    {
        $details = $student->detailsAsStudent;
        $data = array_replace([
            'name' => $student->name,
            'email' => $student->email,
            'city_birth' => $details?->city_birth,
            'date_birth' => $details?->date_birth?->format('Y-m-d'),
            'city' => $details?->city,
            'cap' => $details?->cap,
            'fiscal_code' => $details?->fiscal_code,
            'phone_number' => $details?->phone_number,
            'social' => null,
            'youTube' => null,
            'wordMmouth' => null,
            'research' => null,
            'google' => null,
            'other' => null,
        ], $overrides);

        $options = new Options;
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('livewire.admin.pdf.module-trainee', $data)->render());
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $fileName = 'modulo-iscrizione-'.Str::slug($student->name).'-'.$student->id.'.pdf';
        $filePath = 'documents_student/'.$fileName;

        if (! Storage::disk('public')->put($filePath, $dompdf->output())) {
            throw new RuntimeException('Impossibile salvare il modulo di iscrizione dello studente.');
        }

        return Document::updateOrCreate(
            [
                'student_id' => $student->id,
                'type' => Document::TYPE_MODULO_PDF,
            ],
            [
                'name' => $fileName,
                'url_file' => $filePath,
            ]
        );
    }
}
