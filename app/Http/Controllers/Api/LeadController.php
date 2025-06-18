<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Http\Resources\LeadResource;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        return LeadResource::collection(Lead::latest('utworzono_at')->paginate(20));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'imie' => 'required|string|max:100',
            'nazwisko' => 'required|string|max:100',
            'nazwa_firmy' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:Leady,email',
            'telefon' => 'nullable|string|max:20',
            'zrodlo' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'uwagi' => 'nullable|string',
        ]);

        $lead = Lead::create($validatedData);
        return new LeadResource($lead);
    }

    public function show(Lead $lead)
    {
        return new LeadResource($lead);
    }

    public function update(Request $request, string $id)
    {
        $lead = Lead::findOrFail($id);

        $validatedData = $request->validate([
            'imie' => 'sometimes|required|string|max:100',
            'nazwisko' => 'sometimes|required|string|max:100',
            'nazwa_firmy' => 'nullable|string|max:255',
            'email' => 'sometimes|nullable|email|max:255|unique:Leady,email,' . $lead->id_leada . ',id_leada',
            'telefon' => 'nullable|string|max:20',
            'zrodlo' => 'nullable|string|max:100',
            'status' => 'nullable|string|max:50',
            'uwagi' => 'nullable|string',
        ]);

        $lead->update($validatedData);
        return new LeadResource($lead);
    }

    public function destroy(string $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
        return response()->json(null, 204);
    }
}