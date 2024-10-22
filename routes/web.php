<?php

use App\Http\Controllers\MarvelController;

// Ruta para mostrar los personajes almacenados
Route::get('/characters', [MarvelController::class, 'showCharacters'])->name('characters.index');

// Ruta para obtener personajes de la API y almacenarlos en la base de datos
Route::get('/fetch-characters', [MarvelController::class, 'fetchMarvelCharacters'])->name('characters.fetch');
