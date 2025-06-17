<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Klient;
use Illuminate\Http\Request;
use App\Http\Resources\KlientResource;

class KlientController extends Controller
{
    public function index()
    {
        return KlientResource::collection(Klient::latest('utworzono_at')->paginate(15));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'imie' => 'required|string|max:100',
            'nazwisko' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:Klienci,email',
            'nazwa_firmy' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:20',
        ]);

        $klient = Klient::create($validatedData);

        return new KlientResource($klient);
    }

    public function show(string $id)
    {
        $klient = Klient::findOrFail($id);

        return response()->json(new KlientResource($klient));
    }


        public function update(Request $request, string $id)
    {
        // Najpierw ręcznie znajdujemy klienta
        $klient = Klient::findOrFail($id);

        $validatedData = $request->validate([
            'imie' => 'sometimes|required|string|max:100',
            'nazwisko' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|max:255|unique:Klienci,email,' . $klient->id_klienta . ',id_klienta',
            'nazwa_firmy' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:20',
        ]);
        
        $klient->update($validatedData);

        return response()->json(new KlientResource($klient));
    }


    public function destroy(Klient $klient)
    {
        $klient->delete();
        return response()->json(null, 204);
    }
}