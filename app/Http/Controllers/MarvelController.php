<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Character;

class MarvelController extends Controller
{
    /**
     * Obtiene personajes desde la API de Marvel y los almacena en la base de datos.
     */
    public function fetchMarvelCharacters()
    {
        $timestamp = time();
        $publicKey = env('MARVEL_API_PUBLIC_KEY');
        $privateKey = env('MARVEL_API_PRIVATE_KEY');
        $hash = md5($timestamp . $privateKey . $publicKey);

        // Hacemos la solicitud a la API de Marvel para obtener los primeros 10 personajes
        $response = Http::get('https://gateway.marvel.com/v1/public/characters', [
            'apikey' => $publicKey,
            'ts' => $timestamp,
            'hash' => $hash,
            'limit' => 10
        ]);

        // Verificamos si la respuesta fue exitosa
        if ($response->successful()) {
            $data = $response->json();

            // Recorremos los personajes obtenidos y los almacenamos en la base de datos
            foreach ($data['data']['results'] as $characterData) {
                Character::updateOrCreate(
                    ['name' => $characterData['name']],
                    ['thumbnail' => $characterData['thumbnail']['path'] . '.' . $characterData['thumbnail']['extension']]
                );
            }

            return redirect()->route('characters.index')->with('success', 'Personajes de Marvel almacenados correctamente');
        } else {
            return response()->json(['error' => 'No se pudo obtener datos de la API de Marvel'], 500);
        }
    }

    /**
     * Muestra los personajes almacenados en la base de datos.
     */
    public function showCharacters()
    {
        $characters = Character::all();
        return view('characters.index', compact('characters'));
    }
}
