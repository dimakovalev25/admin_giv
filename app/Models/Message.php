<?php

namespace App;

use DateTimeInterface;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Relations\BelongsTo;

/**
 * Class Message
 * @package App
 * @property string $_id
 * @property string $sender_id
 * @property string $receiver_id
 * @property string $message
 * @property ?User $sender
 * @property ?User $receiver
 * @property ?Order $order
 * @property string $order_id
 * @property bool $is_read
 */
class Message extends Eloquent
{
    protected $collection = 'messages';

    protected static $unguarded = true;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function isUserMessage(string $userId): bool
    {
        return $this->sender_id === $userId || $this->receiver_id === $userId;
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