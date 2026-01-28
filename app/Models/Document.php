<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'type',
        'name',
        'url_file',
    ];

    // Costanti per i tipi di documento
    const TYPE_FOTO_PROFILO = 'foto_profilo';
    const TYPE_DOC_PROFESSIONALE = 'doc_professionale';
    const TYPE_CARTA_IDENTITA = 'carta_identita';
    const TYPE_ALTRO = 'altro';

    //ha un professore (user)
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    //ha un studente (user)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
