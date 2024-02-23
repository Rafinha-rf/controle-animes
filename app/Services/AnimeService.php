<?php

namespace App\Services;

use App\Models\Anime;
use App\Models\Season;
use App\Models\Episode;



class AnimeService {


    public function storeAnimeWithSeasonsAndEpisodes($data)
    {
        
        $anime = Anime::create($data);
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
        
        return $anime;
    }

}