<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\WatchProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class WatchProgressController extends Controller
{
    public function updateProgress(Request $request, Episode $episode)
    {
        Log::info('Atualizando progresso', [
            'episode_id' => $episode->id,
            'status' => $request->status,
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'status' => 'required|in:watched,in_progress,not_watched',
            'current_time' => 'nullable|integer|min:0'
        ]);

        $progress = WatchProgress::updateOrCreate(
            [
                'episode_id' => $episode->id,
                'user_id' => Auth::id()
            ],
            [
                'status' => $request->status,
                'current_time' => $request->current_time,
                'watched_at' => $request->status === 'watched' ? now() : null
            ]
        );

        Log::info('Progresso atualizado', ['progress' => $progress]);

        return response()->json([
            'success' => true,
            'message' => 'Progresso atualizado com sucesso',
            'progress' => $progress,
            'status' => $request->status
        ]);
    }

    public function getProgress(Episode $episode)
    {
        $progress = $episode->getProgressForUser(Auth::id());
        
        return response()->json([
            'success' => true,
            'progress' => $progress
        ]);
    }

    public function markSeasonAsWatched($seasonId)
    {
        Log::info('Marcando temporada como assistida', [
            'season_id' => $seasonId,
            'user_id' => Auth::id()
        ]);

        $episodes = Episode::where('season_id', $seasonId)->get();
        
        foreach ($episodes as $episode) {
            WatchProgress::updateOrCreate(
                [
                    'episode_id' => $episode->id,
                    'user_id' => Auth::id()
                ],
                [
                    'status' => 'watched',
                    'watched_at' => now()
                ]
            );
        }

        Log::info('Temporada marcada como assistida', [
            'season_id' => $seasonId,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Temporada marcada como assistida'
        ]);
    }
} 