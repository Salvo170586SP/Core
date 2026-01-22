<?php

use App\Livewire\Admin\Courses\CoursesCreate;
use App\Livewire\Admin\Courses\CoursesDetail;
use App\Livewire\Admin\Courses\CoursesEdit;
use App\Livewire\Admin\Courses\CoursesIndex;
use App\Livewire\Admin\Teachers\TeachersCreate;
use App\Livewire\Admin\Teachers\TeachersDetail;
use App\Livewire\Admin\Teachers\TeachersEdit;
use App\Livewire\Admin\Teachers\TeachersIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified','role:amministratore'])
    ->name('dashboard');

Route::middleware(['auth', 'role:amministratore'])->group(function () {
    
    Volt::route('professori',TeachersIndex::class)->name('teachers');
    Volt::route('professori/crea',TeachersCreate::class)->name('teachers.create');
    Volt::route('professori/{id}/dettagli',TeachersDetail::class)->name('teachers.detail');
    Volt::route('professori/{id}/modifica',TeachersEdit::class)->name('teachers.edit');
    
    Volt::route('tutti-corsi',CoursesIndex::class)->name('courses');
    Volt::route('tutti-corsi/crea',CoursesCreate::class)->name('courses.create');
    Volt::route('tutti-corsi/{id}/modifica',CoursesEdit::class)->name('courses.edit');
    Volt::route('tutti-corsi/{id}',CoursesDetail::class)->name('courses.detail');

    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
