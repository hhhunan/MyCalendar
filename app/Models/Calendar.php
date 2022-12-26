<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Calendar
 * @property mixed|string title
 * @property mixed|string|null description
 * @property mixed|string start
 * @property int|mixed|null duration
 * @property Carbon|mixed end
 * @property mixed|null user_id
 * @property mixed id
 * @package App\Models
 */
class Calendar extends Model
{
    use HasFactory;
    protected $with = [];

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'duration',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
      'start'=>'datetime',
      'end'=>'datetime',
    ];

    /**
     * @return BelongsTo
     */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
