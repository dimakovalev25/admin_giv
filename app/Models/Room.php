<?php

namespace App;

use DateTimeInterface;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @class Room
 * @package App
 * @property string $_id
 * @property string $name
 * @property int $status
 * @property User $user
 */
class Room extends Model
{

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    const DEFAULT_USER_ROOMS = [
        'Computers & Electronics',
        'Children',
        'Party & Event',
        'Sports & Tourism',
        'Household',
        'Tools',
        'Garden',
        'Kitchen',
        'Sound & Vision',
        'Gaming',
        'Hobby & Leasure'
    ];

    public const STATUS_VISIBLE = 1;
    public const STATUS_SECRET = 2;
    public const STATUS_VISIBLE_FOR_NEIGHBORS = 3;

    protected $collection = 'rooms';

    protected static $unguarded = true;

    /**
     * @return BelongsTo
     */
    public function icon()
    {
        return $this->belongsTo('App\tdRoomIcon', 'icon_id');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * @return HasMany
     */
    public function things()
    {
        return $this->hasMany('App\Thing', 'roomId');
    }

    /**
     * @return int[]
     */
    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_VISIBLE,
            self::STATUS_SECRET,
            self::STATUS_VISIBLE_FOR_NEIGHBORS,
        ];
    }

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

}
