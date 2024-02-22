<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;

class AnimesController extends Controller
{
    public function index()
    {
        $animes = Anime::query()->orderBy('nome')->get();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('animes.index')->with('animes', $animes)
               ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('animes.create');
    }

    public function store(Request $request)
    {
        
        $anime = Anime::create($request->all());
        
        return to_route('animes.index')->with('mensagem.sucesso', "Anime '{$anime->nome}' Adicionado com sucesso");
    }

    public function destroy(Anime $anime)
    {
        $anime->delete();

        return to_route('animes.index')->with('mensagem.sucesso', "Anime '{$anime->nome}' removido com sucesso");
    }

    public function edit(Anime $anime)
    {
        return view('animes.edit')->with('anime', $anime);
    }

    public function update(Anime $anime, Request $request)
    {
        $anime->fill($request->all());
        $anime->save();

        return to_route('animes.index')->with('mensagem.sucesso', "Anime {$anime->nome} editado com sucesso");
    }

}
