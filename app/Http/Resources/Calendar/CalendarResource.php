<?php

namespace App\Http\Resources\Calendar;

use App\Http\Resources\Media\MediaResource;
use App\Http\Resources\User\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProjectResource
 * @package App\Http\Resources\Project
 *
 * @property int $id
 * @property string $title
 * @property Carbon $created_at
 * @property mixed description
 * @property mixed end
 * @property mixed start
 * @property mixed duration
 */
class CalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start' => $this->start,
            'end' => $this->end,
            'duration' => $this->duration,
            'createdAt' => $this->created_at?->format('d M Y'),
            'user' => $this->when(
                $this->user()->exists(),
                function () {
                    return new UserResource($this->user);
                }
            ),
        ];

    }
}
