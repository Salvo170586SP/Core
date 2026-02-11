<?php

use App\Livewire\Admin\Badges\BadgesCourseDetail;
use App\Livewire\Admin\Badges\BadgesDetail;
use App\Livewire\Admin\Badges\BadgesIndex;
use App\Livewire\Admin\CourseModule;
use App\Livewire\Admin\Courses\CoursesCreate;
use App\Livewire\Admin\Courses\CoursesDetail;
use App\Livewire\Admin\Courses\CoursesEdit;
use App\Livewire\Admin\Courses\CoursesIndex;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Documents\DocumentsDetail;
use App\Livewire\Admin\Documents\DocumentsIndex;
use App\Livewire\Admin\EveningCourses\EveningCoursesCreate;
use App\Livewire\Admin\EveningCourses\EveningCoursesDetail;
use App\Livewire\Admin\EveningCourses\EveningCoursesEdit;
use App\Livewire\Admin\EveningCourses\EveningCoursesIndex;
use App\Livewire\Admin\MyAccount\MyAccountIndex;
use App\Livewire\Admin\MyAccount\MyCourses;
use App\Livewire\Admin\MyAccount\MyStudents;
use App\Livewire\Admin\MyAccount\MySubjects;
use App\Livewire\Admin\Students\StudentsCreate;
use App\Livewire\Admin\Students\StudentsDetail;
use App\Livewire\Admin\Students\StudentsEdit;
use App\Livewire\Admin\Students\StudentsIndex;
use App\Livewire\Admin\Teachers\TeachersCreate;
use App\Livewire\Admin\Teachers\TeachersDetail;
use App\Livewire\Admin\Teachers\TeachersEdit;
use App\Livewire\Admin\Teachers\TeachersIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

//REGISTRAZIONE ALLIEVI
Route::get('modulo-corso/{course}/subscribe/{token}', CourseModule::class)->name('module-course');

// Apply redirect middleware to all responses after login
Route::middleware(['redirect_role'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    })->name('home');

    Route::middleware(['auth', 'role:istruttore|allievo'])->group(function () {
        Volt::route('mia-bacheca', MyAccountIndex::class)->name('my-account');
        //bacheca insegnate
        Volt::route('mie-materie', MySubjects::class)->name('my-subjects');
        Volt::route('miei-corsi', MyCourses::class)->name('my-courses');
        Volt::route('miei-allievi', MyStudents::class)->name('my-students');

        Route::redirect('settings', 'settings/profile');
    });

    Route::middleware(['auth', 'role:amministratore'])->group(function () {
        Volt::route('dashboard', Dashboard::class)->name('dashboard');

        Volt::route('professori', TeachersIndex::class)->name('teachers');
        Volt::route('professori/crea', TeachersCreate::class)->name('teachers-create');
        Volt::route('professori/{id}', TeachersDetail::class)->name('teachers-detail');
        Volt::route('professori/{id}/modifica', TeachersEdit::class)->name('teachers-edit');

        Volt::route('allievi', StudentsIndex::class)->name('students');
        Volt::route('allievi/crea', StudentsCreate::class)->name('students-create');
        Volt::route('allievi/{id}', StudentsDetail::class)->name('students-detail');
        Volt::route('allievi/{id}/modifica', StudentsEdit::class)->name('students-edit');

        Volt::route('tutti-corsi', CoursesIndex::class)->name('courses');
        Volt::route('tutti-corsi/crea', CoursesCreate::class)->name('courses-create');
        Volt::route('tutti-corsi/{id}', CoursesDetail::class)->name('courses-detail');
        Volt::route('tutti-corsi/{id}/modifica', CoursesEdit::class)->name('courses-edit');

        Volt::route('corsi-serali', EveningCoursesIndex::class)->name('evening_courses');
        Volt::route('corsi-serali/crea', EveningCoursesCreate::class)->name('evening_courses-create');
        Volt::route('corsi-serali/{id}', EveningCoursesDetail::class)->name('evening_courses-detail');
        Volt::route('corsi-serali/{id}/modifica', EveningCoursesEdit::class)->name('evening_courses-edit');

        Volt::route('tesserini-allievi', BadgesIndex::class)->name('badges-students');
        Volt::route('tesserini-allievi/{id}', BadgesDetail::class)->name('badges-students-detail');
        Volt::route('tesserini-allievi/{id}/corso/{course_id}', BadgesCourseDetail::class)->name('badges-students-course');

        Volt::route('documenti', DocumentsIndex::class)->name('documents');
        Volt::route('documenti/{id}', DocumentsDetail::class)->name('documents-detail');
    });
});

Route::middleware(['auth', 'role:amministratore|istruttore|allievo'])->group(function () {
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
