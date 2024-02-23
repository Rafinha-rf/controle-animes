<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimesFormRequest;
use App\Models\Anime;
use App\Services\AnimeService;

class AnimesController extends Controller
{
    protected $animeService;

    public function __construct(AnimeService $animeService)
    {
        $this->animeService = $animeService;
    }


    public function index()
    {
        $animes = Anime::all();
        $mensagemSucesso = session('mensagem.sucesso');

        return view('animes.index')->with('animes', $animes)
               ->with('mensagemSucesso', $mensagemSucesso);
    }

    public function create()
    {
        return view('animes.create');
    }

    public function store(AnimesFormRequest $request)
    {
        
        $animeData = $request->all();
        $anime = $this->animeService->storeAnimeWithSeasonsAndEpisodes($animeData);
    
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

    public function update(Anime $anime, AnimesFormRequest $request)
    {
        $anime->fill($request->all());
        $anime->save();

        return to_route('animes.index')->with('mensagem.sucesso', "Anime {$anime->nome} editado com sucesso");
    }

}
