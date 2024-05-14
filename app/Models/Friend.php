<?php
namespace App;
use DateTimeInterface;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Relations\HasOne;

/**
 * @property string $who_id
 * @property string $with_id
 * @property string $request
 * @property ?User $friend
 * @property ?User $whoFriend
 * @property ?User $withFriend
 */
class Friend extends Eloquent {

    public const REQUEST_ACCEPT = 'accept';
    public const REQUEST_INVITE = 'invite';

    protected $collection = 'friends';
    protected static $unguarded = true;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';


    public function friend(): HasOne
    {
        return $this->hasOne(User::class, '_id', 'with_id');
    }

    public function whoFriend(): HasOne
    {
        return $this->hasOne(User::class, '_id', 'who_id');
    }

    public function withFriend(): HasOne
    {
        return $this->hasOne(User::class, '_id', 'with_id');
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