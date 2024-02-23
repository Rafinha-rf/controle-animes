<?php

namespace App\Services;

use App\Models\Anime;
use App\Models\Season;
use App\Models\Episode;
use Exception;
use GuzzleHttp\Client;



class AnimeService 
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = new Client([
            'base_uri' => 'https://kitsu.io/api/edge/',
        ]);
    }

    public function storeAnimeWithSeasonsAndEpisodes($data)
    {
        $imagemUrl = $this->getKitsuAnimeImagem($data['nome']);
    
        $anime = Anime::create([
            'nome' => $data['nome'],
            'imagem_url' => $imagemUrl
        ]);

        //dd($anime);

        $seasons = [];
        for ($i=1; $i <= $data['seasonsQty']; $i++){
            $seasons[] = [
                'animes_id' => $anime->id,
                'number' => $i
            ];
        }
        Season::insert($seasons);

        $episodes = [];
        foreach($anime->seasons as $season){

            for ($j=1; $j <= $data['episodePerSeasons']; $j++){
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $j
                ];

            }
        }
        Episode::insert($episodes);
        //dd($anime);
        return $anime;
    }

    public function getKitsuAnimeImagem($animeName)
    {
        try {
            $response = $this->client->get('anime', [
                'query' => [
                    'filter[text]' =>$animeName
                ]
            ]);

            $serachResults = json_decode($response->getBody(), true);

            if (!empty($serachResults['data'])){
                $animeId = $serachResults['data'][0]['id'];

                $response = $this->client->get("anime/{$animeId}");

                $animeData = json_decode($response->getBody(), true);

                if (!empty($animeData['data']['attributes']['posterImage']['original'])) {
                    $imageUrl = $animeData['data']['attributes']['posterImage']['original'];
                    return $imageUrl;
                } else {
                    echo "URL da imagem não encontrada para o anime '$animeName'";
                }
        
            } else {
                echo "Nenhum anime encontrado com o nome '$animeName'";
            }
    
        } catch (Exception $e) {
            echo "Erro ao fazer solicitação à API Kitsu: " . $e->getMessage() . "\n";
        }

    }

    
}