<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notatka;
use App\Http\Resources\NotatkaResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotatkaController extends Controller
{
    public function index(Request $request)
    {
        $query = Notatka::with('uzytkownik')->latest('utworzono_at');

        // Opcjonalne filtrowanie po powiązaniach
        if ($request->has('id_klienta')) {
            $query->where('id_klienta', $request->id_klienta);
        }
        if ($request->has('id_leada')) {
            $query->where('id_leada', $request->id_leada);
        }
        if ($request->has('id_szansy')) {
            $query->where('id_szansy', $request->id_szansy);
        }
        if ($request->has('id_kontaktu')) {
            $query->where('id_kontaktu', $request->id_kontaktu);
        }
        
        return NotatkaResource::collection($query->paginate(10));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tresc_notatki' => 'required|string',
            'id_klienta' => 'nullable|exists:Klienci,id_klienta',
            'id_leada' => 'nullable|exists:Leady,id_leada',
            'id_szansy' => 'nullable|exists:SzanseSprzedazy,id_szansy',
            'id_kontaktu' => 'nullable|exists:Kontakty,id_kontaktu',
        ]);

        // Dodajemy ID zalogowanego użytkownika
        $validatedData['utworzono_przez'] = Auth::id();

        $notatka = Notatka::create($validatedData);
        return new NotatkaResource($notatka->load('uzytkownik'));
    }

    public function show(Notatka $notatka)
    {
        return new NotatkaResource($notatka->load('uzytkownik'));
    }

    public function update(Request $request, Notatka $notatka)
    {
         // Tylko twórca notatki może ją edytować
        $this->authorize('update', $notatka);

        $validatedData = $request->validate([
            'tresc_notatki' => 'sometimes|required|string',
        ]);
        
        $notatka->update($validatedData);
        return new NotatkaResource($notatka->load('uzytkownik'));
    }

    public function destroy(string $id)
    {
        $notatka = Notatka::findOrFail($id);

        // Tylko twórca notatki może ją usunąć
        $this->authorize('delete', $notatka);
        
        $notatka->delete();
        return response()->json(null, 204);
    }
}