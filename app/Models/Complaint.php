<?php

namespace App\Models;

use DateTimeInterface;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Relations\BelongsTo;

/**
 *  Class Complaint
 * @package App
 * @property string $userId
 * * @property string $targetId
 * * @property string $type
 * * @property string $_id
 * * @property string $status
 * * @property string $reason
 */

class Complaint extends Eloquent
{
    const TYPE_COMPLAIN_FEED = 'feed';
    const TYPE_COMPLAIN_THING = 'thing';
    const TYPE_COMPLAIN_USER = 'user';

    const STATUS_PENDING = 'pending';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_REJECTED = 'rejected';

    const REASON = 'default';

    protected $collection = 'complaints';

    protected $keyType = 'string';

    protected static $unguarded = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function feed(): BelongsTo
    {
        return $this->belongsTo(Feed::class, 'targetId');
    }

    public function targetThing(): BelongsTo
    {
        return $this->belongsTo(Thing::class, 'targetId');
    }

    public function targetUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'targetId');
    }

    public function target(): BelongsTo|false
    {
        switch ($this->type) {
            case self::TYPE_COMPLAIN_FEED:
                return $this->belongsTo(Feed::class, 'targetId');
            case self::TYPE_COMPLAIN_THING:
                return $this->belongsTo(Thing::class, 'targetId');
            case self::TYPE_COMPLAIN_USER:
                return $this->belongsTo(User::class, 'targetId');
            default:
                return false;
        }
    }

    public static function getAvailableTypes(): array
    {
        return [
            self::TYPE_COMPLAIN_THING,
            self::TYPE_COMPLAIN_USER,
            self::TYPE_COMPLAIN_FEED
        ];
    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_RESOLVED,
            self::STATUS_REJECTED
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
