<?php

namespace App\Services;

use App\Appointment;
use App\WorkDay;
use App\Interfaces\ScheduleServiceInterface;
use Carbon\Carbon;

class ScheduleService implements ScheduleServiceInterface
{

	public function isAvailableInterval($date, $doctorId, Carbon $start){
		$exists = Appointment::where('doctor_id', $doctorId)
		->where('scheduled_date', $date)
			->where('scheduled_time', $start->format('H:i:s'))
				->exists();
		return !$exists;
	}

	public function getAvailableIntervals($date, $doctorId)
	{
		$workDays = WorkDay::where('active', true)
			->where('day', $this->getDayFromDate($date))
			->where('user_id', $doctorId)->first([
				'morning_start', 'morning_end',
				'afternoon_start', 'afternoon_end'
			]);

		if ($workDays) {
					$morningIntervals = $this->getIntervals(
					$workDays->morning_start,
					$workDays->morning_end,
					$date, $doctorId
			);
				$afternoonIntervals = $this->getIntervals(
					$workDays->afternoon_start,
					$workDays->afternoon_end,
					$date,
					$doctorId
				);
		}else{
			$morningIntervals = [];
			$afternoonIntervals = [];
		}

		$data = [];
		$data['morning'] = $morningIntervals;
		$data['afternoon'] = $afternoonIntervals;

		return $data;
	}


	private function getDayFromDate($date)
	{

		$dateCarbon = new Carbon($date);
		// day of week
		//Carbon 0(sunday) 6(saturday)
		//workday 0(monday) 6(sunday)

		$i = $dateCarbon->dayOfWeek;
		$day = ($i == 0 ? 6 : $i - 1);
		return $day;
	}

	private function getIntervals($start, $end, $date, $doctorId)
	{
		$start = new Carbon($start);
		$end = new Carbon($end);
		$intervals = [];
		while ($start < $end) {

			$interval['start'] = $start->format('g:i A');

			//No existe una hora para este médico
			$exists = $this->isAvailableInterval($date, $doctorId, $start);

			$start->addMinutes(30);
			$interval['end'] = $start->format('g:i A');

			if ($exists) {
				$intervals[] = $interval;
			}
		}
		return $intervals;
	}
}
