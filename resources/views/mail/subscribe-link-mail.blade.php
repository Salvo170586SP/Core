<x-mail::message>
# Ciao Candidato,

Hai ricevuto il link per tesserarti e iscriverti a Core.

Clicca sul pulsante qui sotto per completare la tua iscrizione:

<x-mail::button :url="$subscribeLink">
Iscriviti al Corso
</x-mail::button>

Se hai domande o problemi, non esitare a contattarci.

Grazie,<br>
{{ config('app.name') }}
</x-mail::message>
