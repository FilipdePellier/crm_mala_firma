<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kontakt;
use App\Http\Resources\KontaktResource;
use Illuminate\Http\Request;

class KontaktController extends Controller
{
    public function index()
    {
        return KontaktResource::collection(Kontakt::latest('utworzono_at')->paginate(15));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_klienta' => 'required|exists:Klienci,id_klienta',
            'imie' => 'required|string|max:100',
            'nazwisko' => 'required|string|max:100',
            'stanowisko' => 'nullable|string|max:100',
            'email' => 'nullable|email|max:255|unique:Kontakty,email',
            'telefon' => 'nullable|string|max:20',
        ]);

        $kontakt = Kontakt::create($validatedData);
        return new KontaktResource($kontakt);
    }

    public function show(Kontakt $kontakt)
    {
        return new KontaktResource($kontakt);
    }

    public function update(Request $request, Kontakt $kontakt)
    {
        $validatedData = $request->validate([
            'id_klienta' => 'sometimes|required|exists:Klienci,id_klienta',
            'imie' => 'sometimes|required|string|max:100',
            'nazwisko' => 'sometimes|required|string|max:100',
            'stanowisko' => 'nullable|string|max:100',
            'email' => 'sometimes|nullable|email|max:255|unique:Kontakty,email,' . $kontakt->id_kontaktu . ',id_kontaktu',
            'telefon' => 'nullable|string|max:20',
        ]);

        $kontakt->update($validatedData);
        return new KontaktResource($kontakt);
    }

    public function destroy(Kontakt $kontakt)
    {
        $kontakt->delete();
        return response()->json(null, 204);
    }
}