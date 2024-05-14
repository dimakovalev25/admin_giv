<?php

namespace App;

use DateTimeInterface;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

/**
 * Class Review
 * @package App
 * @property string $user_id
 * @property string $target_id
 * @property string $type
 * @property string $message
 * @property int $rating
 * @property string $order_id
 * @property string $_id
 * @property User $user
 */
class Review extends Eloquent
{
    const TYPE_THING = 'thing';
    const TYPE_USER = 'user';

    protected $collection = 'reviews';

    protected static $unguarded = true;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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