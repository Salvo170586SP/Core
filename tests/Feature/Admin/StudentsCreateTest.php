<?php

use App\Livewire\Admin\Students\StudentsCreate;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;

test('creating a student generates a registration module', function () {
    Storage::fake('public');
    Role::create(['name' => 'allievo', 'guard_name' => 'web']);

    Livewire::test(StudentsCreate::class)
        ->set('studentDetailsStep.name', 'Mario Rossi')
        ->set('studentDetailsStep.email', 'mario@example.com')
        ->set('studentDetailsStep.password', 'password')
        ->set('studentDetailsStep.city_birth', 'Roma')
        ->set('studentDetailsStep.date_birth', '1990-01-01')
        ->set('studentDetailsStep.city', 'Milano')
        ->set('studentDetailsStep.cap', '20100')
        ->set('studentDetailsStep.fiscal_code', 'RSSMRA90A01H501U')
        ->set('studentDetailsStep.phone_number', '3331234567')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect('/allievi');

    $module = Document::where('type', Document::TYPE_MODULO_PDF)->sole();

    expect($module->name)->toEndWith('.pdf');
    expect(Storage::disk('public')->exists($module->url_file))->toBeTrue();
    expect(str_starts_with(Storage::disk('public')->get($module->url_file), '%PDF'))->toBeTrue();
});
