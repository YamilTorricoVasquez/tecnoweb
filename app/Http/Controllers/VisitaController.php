<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visita;

class VisitaController extends Controller
{
    public function incrementar()
    {
        $visita = Visita::first();
        if (!$visita) {
            $visita = Visita::create(['contador' => 1]);
        } else {
            $visita->increment('contador');
        }
        return response()->json(['visitas' => $visita->contador]);
    }

    public function obtener()
    {
        $visita = Visita::first();
        return response()->json(['visitas' => $visita ? $visita->contador : 0]);
    }
}