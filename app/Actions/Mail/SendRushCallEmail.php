<?php

namespace App\Actions\Mail;

use App\Mail\RushCallEmail;
use App\Models\Crew;
use App\Models\ProjectJob;
use Carbon\Carbon;
use Mail;

class SendRushCallEmail
{
    /**
     * @param ProjectJob $projectJob
     */
    public function execute(ProjectJob $projectJob)
    {
        if ($projectJob->rush_call) {
            $crews = Crew::whereExists(
                function ($query) use ($projectJob) {
                    $query->from('crew_position')
                        ->where('position_id', $projectJob->position_id);
                }
            )->get();

            $crews->map(function ($crew) use ($projectJob) {
                Mail::to($crew->user->email)->send(
                    new RushCallEmail($crew->user, (object)$this->format($projectJob))
                );
            });
        }
    }

    /**
     * @param ProjectJob $projectJob
     * @return array
     */
    private function format(ProjectJob $projectJob): array
    {
        return [
            'id'             => $projectJob->id,
            'position_name'  => $projectJob->position->name,
            'pay_type'       => $projectJob->pay_type->name,
            'persons_needed' => $projectJob->persons_needed,
            'dates_needed'   => $this->datesNeededFormat($projectJob->dates_needed),
            'pay_rate'       => $projectJob->pay_rate,
        ];
    }

    /**
     * @param $date
     * @return array|string
     */
    private function datesNeededFormat($date)
    {
        if (is_string($date)) {
            return $this->formatDate($date);
        }

        $date = json_decode($date);

        if (count($date) === 2 && $date[0] === $date[1]) {
            return $this->formatDate($date[0]);
        }

        if (count($date) === 2 && $date[0] !== $date[1]) {
            return $this->formatDate($date[0]) . ' to ' . $this->formatDate($date[1]);
        }

        return $this->multipleDateFormat($date);
    }

    /**
     * @param $date
     * @return string
     */
    private function formatDate($date)
    {
        return Carbon::parse($date)->toFormattedDateString();
    }

    /**
     * @param $dates
     * @return array
     */
    private function multipleDateFormat($dates)
    {
        $formattedDates = [];

        foreach ($dates as $date) {
            array_push($formattedDates, $this->formatDate($date));
        }

        return $formattedDates;
    }
}
