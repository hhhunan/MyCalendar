<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Permission\PermissionResource;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Media\MediaResource;
use App\Models\Permission\Permission;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Class UserResource
 * @package App\Http\Resources\User
 *
 * @property int $id
 * @property string $user_name
 * @property string $name
 * @property string $email
 * @property Carbon $created_at
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->created_at->format('d M Y')
            ];
            
    }
}
