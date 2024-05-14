<?php

namespace App;

use DateTimeInterface;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

/**
 * Class Like
 * @package App
 * @property string $user_id
 * @property string $target_id
 * @property string $type
 * @property string $_id
 */
class Like extends Eloquent
{

    const TYPE_FEED = 'feed';
    const TYPE_THING = 'thing';
    const TYPE_USER = 'user';

    protected $collection = 'likes';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected static $unguarded = true;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class, 'target_id');
    }

    public function thing()
    {
        return $this->belongsTo(Thing::class, 'target_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_id');
    }

    public function target()
    {
        switch ($this->type) {
            case self::TYPE_FEED:
                return $this->belongsTo(Feed::class, 'target_id');
            case self::TYPE_THING:
                return $this->belongsTo(Thing::class, 'target_id');
            case self::TYPE_USER:
                return $this->belongsTo(User::class, 'target_id');
            default:
                return false;
        }
    }

    public static function getAvailableTypes(): array
    {
        return [
            self::TYPE_FEED,
            self::TYPE_THING,
            self::TYPE_USER
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