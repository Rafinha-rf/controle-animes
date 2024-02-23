<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimesFormRequest;
use App\Models\Anime;
use App\Models\Episode;
use App\Models\Season;
use Illuminate\Http\Request;

class AnimesController extends Controller
{
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
        
        $anime = Anime::create($request->all());
        $seasons = [];
        for ($i=1; $i <= $request->seasonsQty; $i++){
            $seasons[] = [
                'animes_id' => $anime->id,
                'number' => $i
            ];
        }
        Season::insert($seasons);

        $episodes = [];
        foreach($anime->seasons as $season){

            for ($j=1; $j <= $request->episodePerSeasons; $j++){
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $j
                ];

            }
        }
        Episode::insert($episodes);
        
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
