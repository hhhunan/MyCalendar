<?php

namespace App\Repositories;


use App\Contracts\Repositories\CalendarRepositoryInterface;
use App\Models\Calendar;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

/**
 * Class CalendarRepository
 * @package App\Repositories
 */
class CalendarRepository extends Repository implements CalendarRepositoryInterface
{
    /**
     * @return string
     */
    public function getModelClassName(): string
    {
        return Calendar::class;
    }
    protected array $with = [];

    /**
     * @return Collection[]|null
     */
    public function getCalendarBetweenDates($startDate, $endDate,array $relations = []): ?Collection
    {
        return $this->model()->where(function($q) use ($startDate, $endDate){
            $q->whereBetween('start', [$startDate, $endDate])
                ->orWhereBetween('end', [$startDate, $endDate]);
        })->where('user_id', auth('api')->user()->id)
            ->get();
    }

    /**
     * @param int $id
     * @return Calendar|null
     */
    public function findById(int $id): ?Calendar
    {
        /**
         * @var Calendar|null $result
         */
        $result = $this->model()->with(['user'])->where('id', $id)->first();

        return $result;
    }


    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->model()->where('id', $id)->delete();
    }

    public function checkAvailableToDelete(Calendar $calendar): bool
    {
        return $calendar->user_id == \auth('api')->user()->id &&
            strtotime(Carbon::now()->addHours(3)) < strtotime(Carbon::parse($calendar->start));
    }

    public function checkAvailableAddByAnonymousUser($start, $end): bool
    {
        return !($this->model()->whereNot(function ($q) use ($start, $end){
            $q->whereBetween('start', [$start, $end])
                ->orWhereBetween('end', [$start, $end]);
        })->exists());

    }
}
