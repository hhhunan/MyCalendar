<?php

namespace App\Contracts\Repositories;

use App\Models\Calendar;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface UserRepositoryInterface
 * @package App\Contracts\Repositories
 */
interface CalendarRepositoryInterface extends RepositoryInterface
{
    /**
     * @return Collection[]|null
     */
    public function getCalendarBetweenDates($startDate, $endDate, array $relations = []): ?Collection;

    /**
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?Calendar;

    /**
     * @param \App\Models\Calendar $calendar
     * @return bool
     */
    public function checkAvailableToDelete(Calendar $calendar): bool;

    /**
     * @param $start
     * @param $end
     * @return bool
     */
    public function checkAvailableAddByAnonymousUser($start, $end): bool;
}
