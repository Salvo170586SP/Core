<?php

return [
    'dashboard' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
    ],


    /* Insegnanti */
    'teachers' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Professori'],
    ],
    'teachers-create' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Professori', 'route' => 'teachers'],
        ['label' => 'Aggiungi'],
    ],
    'teachers-detail' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Professori', 'route' => 'teachers'],
        ['label' => 'Dettagli'],
    ],
    'teachers-edit' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Professori', 'route' => 'teachers'],
        ['label' => 'Modifica'],
    ],


    /* Allievi */
    'students' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Allievi'],
    ],
    'students-create' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Allievi', 'route' => 'students'],
        ['label' => 'Crea'],
    ],
    'students-detail' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Allievi', 'route' => 'students'],
        ['label' => 'Dettagli'],
    ],
    'students-edit' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Allievi', 'route' => 'students'],
        ['label' => 'Modifica'],
    ],
    
    /* Corsi */
    'courses' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Tutti i Corsi'],
    ],
    'courses-create' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Tutti i Corsi', 'route' => 'courses'],
        ['label' => 'Crea'],
    ],
    'courses-detail' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Tutti i Corsi', 'route' => 'courses'],
        ['label' => 'Dettagli'],
    ],
    'courses-edit' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Tutti i Corsi', 'route' => 'courses'],
        ['label' => 'Modifica'],
    ],
    
    /* Corsi serali */
    'evening_courses' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Corsi Serali'],
    ],
    'evening_courses-create' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Corsi Serali', 'route' => 'evening_courses'],
        ['label' => 'Crea'],
    ],
    'evening_courses-detail' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Corsi Serali', 'route' => 'evening_courses'],
        ['label' => 'Dettagli'],
    ],
    'evening_courses-edit' => [
        ['label' => 'Home', 'route' => 'dashboard', 'icon' => 'home'],
        ['label' => 'Corsi Serali', 'route' => 'evening_courses'],
        ['label' => 'Modifica'],
    ],
];
