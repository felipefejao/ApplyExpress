<?php

namespace App\Http\Controllers;

use App\Models\Vaga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class JobBoardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Vaga::where('is_public', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('empresa', 'like', "%{$search}%")
                    ->orWhere('cargo', 'like', "%{$search}%")
                    ->orWhereJsonContains('slug', $search);
            });
        }

        $vagas = $query->latest()->get();

        if ($request->ajax()) {
            return view('job-board._list', compact('vagas'));
        }

        return view('job-board.index', compact('vagas', 'search'));
    }

    public function details(string $id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
            $vaga = Vaga::findOrFail($decryptedId);

            return view('job-board.details', compact('vaga'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function apply(Vaga $vaga)
    {
        // Clona a vaga para o usuário atual
        $newVaga = $vaga->replicate();
        $newVaga->user_id = auth()->id();
        $newVaga->is_public = false;
        $newVaga->enviado = false;

        // Gera um novo slug ou limpa se for privado
        $newVaga->slug = null;

        $newVaga->save();

        return back()->with('success', 'Vaga adicionada à sua lista de candidaturas!');
    }
}
