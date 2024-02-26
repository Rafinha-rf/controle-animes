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
        $dataAnime = $this->getKitsuAnimeImagem($data['nome']);
        if ($dataAnime === null){
            return null;
        } 
    
        $anime = Anime::create([
            'nome' => $dataAnime[0],
            'imagem_url' => $dataAnime[1]
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
                    'filter[text]' => $animeName,
                ]
            ]);

            $searchResults = json_decode($response->getBody(), true);

            usort($searchResults['data'], function($a, $b) {
                return strtotime($a['attributes']['createdAt']) - strtotime($b['attributes']['createdAt']);
            });

            if (!empty($searchResults['data'])){
                // Procura pelo anime com o nome original correspondente
                foreach ($searchResults['data'] as $animeItem) {
                    if (stripos($animeItem['attributes']['titles']['en_jp'], $animeName) !== false || stripos($animeItem['attributes']['titles']['en_us'], $animeName) !== false) {
                        $animeId = $searchResults['data'][0]['id'];
                        $response = $this->client->get("anime/{$animeId}");
                        $animeData = json_decode($response->getBody(), true);
                        if (!empty($animeData['data']['attributes']['posterImage']['original'])) {
                            return array($animeData['data']['attributes']['titles']['en_jp'], $animeData['data']['attributes']['posterImage']['original']);
                        } else {
                            return null;
                        }
                        break;
                    }
                }
                return null;
            } else {
                return null;
            } 
    
        } catch (Exception $e) {
            return null;
        }

    }

}