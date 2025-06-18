<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SzanseSprzedazy;
use App\Http\Resources\SzanseSprzedazyResource;
use Illuminate\Http\Request;

class SzanseSprzedazyController extends Controller
{
    public function index()
    {
        return SzanseSprzedazyResource::collection(SzanseSprzedazy::with(['klient', 'kontakt'])->latest('utworzono_at')->paginate(15));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_klienta' => 'required|exists:Klienci,id_klienta',
            'id_kontaktu' => 'nullable|exists:Kontakty,id_kontaktu',
            'nazwa' => 'required|string|max:255',
            'etap' => 'required|string|max:50',
            'wartosc' => 'nullable|numeric|min:0',
            'data_zamkniecia' => 'nullable|date',
            'opis' => 'nullable|string',
        ]);

        $szansa = SzanseSprzedazy::create($validatedData);
        return new SzanseSprzedazyResource($szansa->load(['klient', 'kontakt']));
    }

    public function show(SzanseSprzedazy $szanseSprzedazy)
    {
        return new SzanseSprzedazyResource($szanseSprzedazy->load(['klient', 'kontakt']));
    }

    public function update(Request $request, SzanseSprzedazy $szanseSprzedazy)
    {
        $validatedData = $request->validate([
            'id_klienta' => 'sometimes|required|exists:Klienci,id_klienta',
            'id_kontaktu' => 'nullable|exists:Kontakty,id_kontaktu',
            'nazwa' => 'sometimes|required|string|max:255',
            'etap' => 'sometimes|required|string|max:50',
            'wartosc' => 'nullable|numeric|min:0',
            'data_zamkniecia' => 'nullable|date',
            'opis' => 'nullable|string',
        ]);

        $szanseSprzedazy->update($validatedData);
        return new SzanseSprzedazyResource($szanseSprzedazy->load(['klient', 'kontakt']));
    }

    public function destroy(SzanseSprzedazy $szanseSprzedazy)
    {
        $szanseSprzedazy->delete();
        return response()->json(null, 204);
    }
}