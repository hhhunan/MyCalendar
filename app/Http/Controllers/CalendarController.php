<?php

namespace App\Http\Controllers;

use App\Exceptions\BusinessLogicExceptions\CalendarNotAvailableForDeleteException;
use App\Http\Requests\DestroyCalendarRequest;
use App\Http\Requests\GetCalendarRequest;
use App\Http\Requests\GetCalendarsRequest;
use App\Http\Resources\Calendar\CalendarResource;
use App\Http\Services\Calendar\CalendarService;
use App\Models\Calendar;
use App\Http\Requests\StoreCalendarRequest;
use App\Http\Requests\UpdateCalendarRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CalendarController extends Controller
{

    private CalendarService $calendarService;

    /**
     * AuthController constructor.
     * @param CalendarService $calendarService
     */
    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    /**
     * @param GetCalendarsRequest $request
     * @return AnonymousResourceCollection
     */
    public function getBetweenDatesAction(GetCalendarsRequest $request): AnonymousResourceCollection
    {

        $calendar = $this->calendarService->getByBetweenDates($request->getStart(), $request->getEnd(), []);
        return CalendarResource::collection($calendar);
    }
    /**
     * Register a new user
     */
    public function createAction(StoreCalendarRequest $request):CalendarResource
    {

        $calendar = $this->calendarService->create(
            $request->getTitle(),
            $request->getStart(),
            $request->getDuration(),
            $request->getDescription(),
        );
        return new CalendarResource($calendar);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Calendar $calendar
     * @param \App\Http\Requests\GetCalendarRequest $request
     * @return \App\Http\Resources\Calendar\CalendarResource
     * @throws \App\Exceptions\BusinessLogicExceptions\CalendarNotFoundException
     */
    public function getAction(Calendar $calendar, GetCalendarRequest $request): CalendarResource
    {
        $calendar =  $this -> calendarService -> findOrFailById($request->getId());
        return new CalendarResource($calendar);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateCalendarRequest $request
     * @return \App\Http\Resources\Calendar\CalendarResource
     * @throws \App\Exceptions\BusinessLogicExceptions\CalendarNotFoundException
     */
    public function updateAction(UpdateCalendarRequest $request):CalendarResource
    {
        $calendar =  $this->calendarService->update($this -> calendarService -> findOrFailById($request->getId()), $request);
        return new CalendarResource($calendar);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Http\Requests\DestroyCalendarRequest $request
     * @return int
     * @throws \App\Exceptions\BusinessLogicExceptions\CalendarNotFoundException
     * @throws \App\Exceptions\BusinessLogicExceptions\CalendarNotAvailableForDeleteException
     */
    public function destroyAction(DestroyCalendarRequest $request):int | CalendarNotAvailableForDeleteException
    {
        if ($this->calendarService->destroy($this -> calendarService -> findOrFailById($request->getId()), $request))
            return Response::HTTP_OK;
        return throw new CalendarNotAvailableForDeleteException();
    }


}
