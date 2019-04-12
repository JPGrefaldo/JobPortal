<?php

namespace App\Actions\Mail;

use App\Mail\RushCallEmail;
use App\Models\Crew;
use App\Models\ProjectJob;
use Carbon\Carbon;

class SendRushCallEmail
{

    public function execute(ProjectJob $projectJob)
    {
        if ($projectJob->rush_call) {
            $crews = Crew::whereExists(
                            function($query) use($projectJob) {
                                $query->select(\DB::raw(1))
                                    ->from('crew_position')
                                    ->where('position_id', '=', $projectJob->position_id);
                            }
                        )->get();

            $crews->map(function($crew) use($projectJob) {
                \Mail::to($crew->user->email)->send(
                    new RushCallEmail($crew->user, (object) $this->format($projectJob))
                );
            });   
        }
    }

    private function format(ProjectJob $projectJob)
    {
        return [
            'id'                    => $projectJob->id,
            'position_name'         => $projectJob->position->name,
            'pay_type'              => $projectJob->pay_type->name,
            'persons_needed'        => $projectJob->persons_needed,
            'dates_needed'          => $this->datesNeededFormat($projectJob->dates_needed),
            'pay_rate'              => $projectJob->pay_rate,
        ];
    }


    private function datesNeededFormat($date)
    {
        if (is_string($date)) {
            return $this->formatDate($date);
        }

        $date = json_decode($date);

        if (count($date) === 2 && $date[0] === $date[1]) {
            return  $this->formatDate($date[0]);
        }

        if (count($date) === 2 && $date[0] !== $date[1]) {
            return $this->formatDate($date[0]).' to '.$this->formatDate($date[1]); 
        }

        return $this->multipleDateFormat($date);
    }

    private function multipleDateFormat($dates)
    {
        $formattedDates = [];

        foreach ($dates as $date) {
            array_push($formattedDates, $this->formatDate($date));
        }

        return $formattedDates;
    }

    private function formatDate($date)
    {
        return Carbon::parse($date)->toFormattedDateString();
    }
}