<?php

namespace App\Http\Services\Calendar;

use App\Contracts\Repositories\CalendarRepositoryInterface;
use App\Contracts\Repositories\UserRepositoryInterface;
use App\Exceptions\BusinessLogicExceptions\CalendarNotAvailableForAddException;
use App\Exceptions\BusinessLogicExceptions\CalendarNotFoundException;
use App\Http\Requests\DestroyCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;
use App\Models\Calendar;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProjectService
 * @package App\Services\Project\ProjectService
 */
class CalendarService
{

    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $userRepository;
    private CalendarRepositoryInterface $calendarRepository;

    /**
     * @param CalendarRepositoryInterface $calendarRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct
    (
        CalendarRepositoryInterface $calendarRepository,
        UserRepositoryInterface $userRepository,
    )
    {
        $this->calendarRepository = $calendarRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $relations
     * @return Collection |null
     */
    public function getByBetweenDates($startDate, $endDate, array $relations = []): ?Collection
    {
        return $this->calendarRepository->getCalendarBetweenDates($startDate,$endDate, $relations);
    }

    /**
     * @param string $title
     * @param string $start
     * @param int $duration
     * @param string|null $description
     * @return Calendar|null
     */
    public function create(
        string $title,
        string $start,
        int $duration,
        ?string $description,
    ): ?Calendar
    {
        if(!(\auth('api')->check()) && !$this->calendarRepository
                ->checkAvailableAddByAnonymousUser(Carbon::parse($start), Carbon::parse($start)->addMinutes($duration)))
           return throw new CalendarNotAvailableForAddException();

        $calendar = new Calendar();
        $calendar->title = $title;
        $calendar->description = $description;
        $calendar->start = $start;
        $calendar->user_id = Auth::guard('api')->check()? Auth::guard('api')->id():NUll;
        $calendar->duration = $duration;
        $calendar->end = Carbon::parse($start)->addMinutes($duration);
        $calendar->save();
        return $calendar;
    }

    /**
     * @param Calendar $calendar
     * @param UpdateCalendarRequest $request
     * @return Calendar
     */
    public function update(Calendar $calendar, UpdateCalendarRequest $request): Calendar
    {
        $calendar->update(
            [
            'title' => $request->getTitle(),
            'description' => $request->getDescription(),
            'start' => $request->getStart(),
            'duration' => $request->getDuration(),
            'end' => Carbon::parse($request->getStart())->addMinutes($request->getDuration())
        ]);

        return $calendar;
    }

    /**
     * @param int $id
     * @return Calendar|CalendarNotFoundException
     * @throws CalendarNotFoundException
     */
    public function findOrFailById(int $id): Calendar | CalendarNotFoundException
    {
        $calendar = $this->calendarRepository->with(['user'])->findById($id);
        if (!$calendar) {
            throw new CalendarNotFoundException();
        }

        return $calendar;
    }
    public function findById(int $id): Calendar | CalendarNotFoundException
    {
        $calendar = $this->calendarRepository->with(['user'])->findById($id);
        if (!$calendar) {
            throw new CalendarNotFoundException();
        }

        return $calendar;
    }

    public function destroy(Calendar $calendar, DestroyCalendarRequest $request): bool
    {
        if ($this->calendarRepository->checkAvailableToDelete($calendar))
        return $calendar -> destroy($calendar->id);
        return false;
    }
}
