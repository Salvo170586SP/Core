<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class TimeHhMm implements CastsAttributes
{
    /**
     * Cast the given value (dal database al modello)
     */
    public function get(Model $model, string $key, $value, array $attributes)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Se è già nel formato H:i, restituiscilo
        if (is_string($value) && preg_match('/^\d{2}:\d{2}$/', $value)) {
            return $value;
        }

        // Se è nel formato H:i:s, estrai solo H:i
        if (is_string($value) && preg_match('/^(\d{2}:\d{2}):\d{2}$/', $value, $matches)) {
            return $matches[1];
        }

        return $value;
    }

    /**
     * Prepare the given value for storage (dal modello al database)
     */
    public function set(Model $model, string $key, $value, array $attributes)
    {
        if ($value === null || $value === '') {
            return null;
        }

        // Se è già nel formato H:i:s, restituiscilo
        if (is_string($value) && preg_match('/^\d{2}:\d{2}:\d{2}$/', $value)) {
            return $value;
        }

        // Se è nel formato H:i, aggiungi :00 per il database
        if (is_string($value) && preg_match('/^\d{2}:\d{2}$/', $value)) {
            return $value . ':00';
        }

        return $value;
    }
}
