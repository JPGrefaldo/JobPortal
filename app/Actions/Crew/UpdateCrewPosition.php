<?php

namespace App\Actions\Crew;

use App\Models\Crew;
use App\Models\CrewPosition;
use App\Models\Position;

class UpdateCrewPosition
{
    /**
     * @param \App\Models\Crew $crew
     * @param \App\Models\Position $position
     * @param array $data
     */
    public function execute(Crew $crew, Position $position, array $data): void
    {
        $crewPosition = CrewPosition::byCrewAndPosition($crew, $position)->first();

        $crewPosition->update([
            'details'           => $data['bio'],
            'union_description' => $data['union_description'],
        ]);

        if ($data['gear'] != null) {
            if ($crew->gears()->where('crew_position_id', $crewPosition->id)->first()) {
                $crew->gears()->update([
                    'description'      => $data['gear'],
                    'crew_position_id' => $crewPosition->id,
                ]);
            } else {
                $crew->gears()->create([
                    'description'      => $data['gear'],
                    'crew_position_id' => $crewPosition->id,
                ]);
            }
        }

        if ($data['reel_link'] != null) {
            if ($crew->reels()->where('crew_position_id', $crewPosition->id)->first()) {
                $crew->reels()->update([
                    'crew_id'          => $crew->id,
                    'path'             => $data['reel_link'],
                    'crew_position_id' => $crewPosition->id,
                ]);
            } else {
                $crew->reels()->create([
                    'crew_id'          => $crew->id,
                    'path'             => $data['reel_link'],
                    'crew_position_id' => $crewPosition->id,
                ]);
            }
        }

        if ($data['resume'] != null) {
            \Log::info($data['resume']);

            $exploded = explode(',', $data['resume']);
            $decoded  = base64_decode($exploded[1]);
    
            if (str_contains($exploded[0], 'pdf')) {
                $extension = 'pdf';
            } elseif (str_contains($exploded[0], 'doc')) {
                $extension = 'doc';
            } elseif (str_contains($exploded[0], 'docx')) {
                $extension = 'docx';
            }
    
            $fileName = str_random() . '.' . $extension;
            $path     = public_path() . '/' . $fileName; // Not sure where can I put uploaded resume
            file_put_contents($path, $decoded);
    
            // $data->resume = base64_decode($request->resume); // base64 to file
        }
    }
}
