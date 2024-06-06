<?php

namespace App\Models;

use DateTimeInterface;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Eloquent\SoftDeletes;
use MongoDB\Laravel\Relations\BelongsTo;

/**
 * Class IdentityDocument
 * @package App
 * @property string $userId
 * @property string $status
 * @property string $_id
 * @property array $images
 */

class IdentityDocument extends Eloquent {

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $collection = 'identity_documents';

    protected static $unguarded = true;

    const STATUS_PENDING = 'pending';
    const STATUS_RESOLVED = 'resolved';
    const STATUS_REJECTED = 'rejected';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
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
