<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modulo di Iscrizione</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        .content {
            padding: 20px;
        }

        .section {
            margin-bottom: 15px;
        }

        .field {
            margin-bottom: 5px;
        }

        .label {
            font-weight: bold;
        }

        .value {
            margin-left: 10px;
        }

        .text-center {
            text-align: center;
        }

        .bold {
            font-weight: bolder;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div style="text-align: justify">

        <h2 class="font-bold mb-3">DOMANDA DI TESSERAMENTO E ISCRIZIONE AI CORSI</h2>
        <div class="w-full">
            Il/La sottoscritto/a nome__<span class="bold">{{$name}}</span>, nato/a a __<span
                class="bold">{{$city_birth}}</span>__,
            il __<span class="bold">{{$date_birth}}</span>__, residente a __<span class="bold">{{$city}}</span>__,
            CAP __<span class="bold">{{$cap}}</span>__,
            Codice fiscale __<span class="bold">{{$fiscal_code}}</span>__, Cellulare __<span
                class="bold">{{$phone_number}}</span>__,
            E-mail __<span class="bold">{{$email}}</span>__
        </div>

        <h3 class="font-semibold mb-1 mt-3 text-center">CHIEDE</h3>
        <div class="text-justify">
            Per mezzo dell'ente Core School con
            la
            firma della presente, di essere ammesso/a in qualità di tesserato nel corso,
            riconosciuto dall'ente e di poter partecipare alle attività organizzate
        </div>

        <h3 class="font-semibold mb-1 mt-3 text-center">AUTORIZZA</h3>
        <div style="margin-bottom: 5px">
            Dichiarazione di Consenso e Responsabilità Il sottoscritto, con l'invio del presente modulo, dichiara di
            aver preso visione del regolamento e di autorizzare l'iscrizione alle attività previste. Si assume la piena
            responsabilità per le informazioni fornite e dichiara di essere in possesso dei requisiti richiesti.
            Autorizza altresì il trattamento dei dati personali ai sensi del Regolamento UE 2016/679 (GDPR) per le
            finalità strettamente connesse alla gestione dell'iscrizione.
        </div>

        <div class="flex justify-center items-center w-full my-3">
            <label for="acconsente" class="flex me-5">
                SI
                <input id="acconsente" type="radio" wire:model="autorizza" checked value="yes" class="mx-2 rounded">
            </label>
            <label for="nonAcconsente" class="flex">
                NO
                <input id="nonAcconsente" type="radio" wire:model="autorizza" value="no" class="mx-2 rounded">
            </label>
        </div>

        <h3 class="font-semibold mb-1 mt-3 text-center">COME CI HAI CONOSCIUTO?</h3>

        <div style="margin-bottom: 5px">
            Come sei venuto/a a conoscenza del corso di difesa personale KMA:
        </div>
        <div style="margin-bottom: 5px">
            <div>
                <label for="social" class="flex items-center mb-1">
                    <input type="checkbox" id="social" @checked($social) wire:modal="social" class="rounded me-2">
                    Pubblicità (facebook/instagram)
                </label>
                <label for="youTube" class="flex items-center mb-1">
                    <input type="checkbox" id="youTube" @checked($youTube) wire:modal="youTube" class="rounded me-2">
                    Youtube
                </label>

                <label for="wordMmouth" class="flex items-center mb-1">
                    <input type="checkbox" id="wordMmouth" @checked($wordMmouth) wire:modal="wordMmouth"
                        class="rounded me-2">
                    Passaparola
                </label>
                <label for="research" class="flex items-center mb-1">
                    <input type="checkbox" id="research" @checked($research) wire:modal="research" class="rounded me-2">
                    Ricerca
                </label>

                <label for="google" class="flex items-center mb-1">
                    <input type="checkbox" id="google" @checked($google) wire:modal="google" class="rounded me-2">
                    su Google
                </label>

                <div style="margin: 10px 10px">
                    Altro __<span class="bold">{{ $other }}</span>__
                </div>
            </div>
        </div>

    </div>
</body>

</html>