<div>
    @if($formSubmitted)
    <div class="text-center text-black">
        <h3 class="font-bold text-2xl">Modulo inviato con successo!</h3>
    </div>
    @else

    <div class="bg-white rounded p-2 h-full">
        <h2 class="w-full text-center font-bold text-lg mb-5">DOMANDA DI TESSERAMENTO E ISCRIZIONE AL CORSO DI {{
            strtoupper($course->name)}}</h2>
        <h3 class="font-semibold text-xs mb-3">(*) i campi sono obbligatori</h3>
        <div class="grid grid-cols-3 gap-3 w-full pb-10 mb-10 border-b border-zinc-300">
            <div class="flex flex-col mb-2">
                <flux:input id="surname" label="Il/La sottoscritto/a (nome e cognome)*" wire:model="name"
                    variant="filled" />
            </div>
            <div class="flex flex-col mb-2">
                <flux:input id="city_birth" label="Nato a*" wire:model="city_birth" variant="filled" />
            </div>
            <div class="flex flex-col mb-2">
                <flux:input id="date_birth" label="Il*" type="date" wire:model="date_birth" variant="filled" />
            </div>
            <div class="flex flex-col mb-2">
                <flux:input id="city" label="Residente in (città)*" wire:model="city" variant="filled" />
            </div>
            <div class="flex flex-col mb-2">
                <flux:input id="cap" label="Cap*" wire:model="cap" variant="filled" />
            </div>
            <div class="flex flex-col mb-2">
                <flux:input id="fiscal_code" label="Codice fiscale*" wire:model="fiscal_code" variant="filled" />
            </div>
            <div class="flex flex-col mb-2">
                <flux:input id="phone_number" label="Numero di telefono*" wire:model="phone_number" variant="filled" />
            </div>
            <div class="flex flex-col mb-2">
                <flux:input type="email" label="Email*" id="email" wire:model="email" variant="filled" />
            </div>
        </div>

        <h3 class="font-semibold mb-1 mt-3 text-center text-lg">CHIEDE</h3>
        <div class="text-center mb-15">
            Per mezzo dell'ente Core School con
            la
            firma della presente, di essere ammesso/a in qualità di tesserato nel corso,
            riconosciuto dall'ente e di poter partecipare alle attività organizzate
        </div>


        <h3 class="font-semibold mb-1 mt-3 text-center text-lg">AUTORIZZA</h3>
        <div class="text-center">
            Dichiarazione di Consenso e Responsabilità Il sottoscritto, con l'invio del presente modulo, dichiara di
            aver preso visione del regolamento e di autorizzare l'iscrizione alle attività previste. Si assume la piena
            responsabilità per le informazioni fornite e dichiara di essere in possesso dei requisiti richiesti.
            Autorizza altresì il trattamento dei dati personali ai sensi del Regolamento UE 2016/679 (GDPR) per le
            finalità strettamente connesse alla gestione dell'iscrizione.
        </div>
        <div class="flex flex-col justify-center items-center w-full my-3 pb-10 mb-10 border-b border-zinc-300">
            <div class="flex justify-center items-center w-full my-3">
                <label for="autorizza" class="flex items-center font-semibold text-lg me-5">
                    SI
                    <input id="autorizza" type="radio" wire:model="autorizza" value="yes"
                        class="form-radio text-[#080808] border-[#D8D5D5] focus:ring-0 mx-2">
                </label>
                <label for="nonAutorizza" class="flex items-center text-lg">
                    NO
                    <input id="nonAutorizza" type="radio" wire:model="autorizza" value="no"
                        class="form-radio text-[#080808] border-[#D8D5D5] focus:ring-0 mx-2">
                </label>
            </div>
            <div>
                @error('autorizza')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>



        <h3 class="font-semibold mb-1 mt-10 text-center text-lg">COME CI HAI CONOSCIUTO?</h3>
        <div class="text-center mb-10">
            Come sei venuto/a a conoscenza dei nostri corsi:
        </div>
        <div class="flex flex-col items-center justify-center my-3 pb-10 mb-10 border-b border-zinc-300">
            <div class="space-y-2 space-x-10 grid grid-cols-2 place-items-start">
                <label for="social">
                    <input type="checkbox" id="social" wire:model="social" class="w-4 h-4" />
                    Social (facebook/instagram)
                </label>
                <label for="YouTube">
                    <input type="checkbox" id="YouTube" wire:model="youTube" class="w-4 h-4" />
                    You Tube
                </label>
                <label for="wordMmouth">
                    <input type="checkbox" id="wordMmouth" wire:model="wordMmouth" class="w-4 h-4" />
                    Passaparola
                </label>
                <label for="research">
                    <input type="checkbox" id="research" wire:model="research" class="w-4 h-4" />
                    Ricerca
                </label>
                <label for="google">
                    <input type="checkbox" id="google" wire:model="google" class="w-4 h-4" />
                    Google
                </label>
            </div>
            <div class="pt-5 w-150">
                <flux:input label="Altro" id="other" wire:model="other" variant="filled" />
            </div>
        </div>


    </div>
    @if($errors->any())
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
        <strong>Attenzione!</strong> Ci sono campi obbligatori da compilare.
    </div>
    @endif
    {{$otp}}
    {{-- @dump($otp) --}}
    <div class="w-full text-center mt-5">
        @if(!$otpSent)
        <!-- Primo step: Invio OTP -->
        <div class="mb-2 font-bold">
            <div>*Cliccando su "Invia" ti verrà inviata un'email con il codice OTP per confermare la tua identità.</div>
            <div>Copialo e torna qui per inserirlo e inviare il modulo.</div>
        </div>
        <button wire:click="sendOtp" wire:target="sendOtp" wire:loading.attr="disabled"
            class="{{ $otpSent ? 'bg-gray-500 cursor-not-allowed' : 'bg-black hover:bg-[#2b2929]' }} font-medium text-white py-2 px-4 rounded">
            Invia
        </button>
        @elseif($otpSent && !$isVerified)
        <!-- Secondo step: Inserisci OTP -->
        <div class="w-full flex justify-center mb-4">
            <flux:input label="Inserisci il codice OTP ricevuto via email" id="enteredOtp" wire:model="enteredOtp"
                variant="filled" />

            @if($otpError)
            <div class="text-red-500 text-sm mt-1">{{ $otpError }}</div>
            @endif
        </div>
        <button wire:click="verifyOtp" wire:target="verifyOtp" wire:loading.attr="disabled"
            class="{{ $isVerified ? 'bg-gray-500 cursor-not-allowed' : 'bg-green-500 hover:bg-green-700' }} font-medium text-white py-2 px-4 rounded">
            Verifica OTP
        </button>


        @elseif($otpSent && $isVerified)
        <!-- Terzo step: Conferma e invio modulo -->
        <div class="mb-2">
            OTP verificato con successo! Puoi ora inviare il modulo.
        </div>
        <button wire:click="saveModule" class="bg-red-500 font-medium hover:bg-red-700 text-white py-2 px-4 rounded">
            Invia Modulo
        </button>
        @endif
    </div>

    <div wire:loading wire:target="sendOtp,verifyOtp,saveModule" class="text-center font-semibold mt-2 text-gray-700">
        Operazione in corso, attendere...
    </div>

    @endif
</div>