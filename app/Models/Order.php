<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Relations\HasMany;

/**
 * Class Order
 * @package App
 * @property string $_id
 * @property string $from
 * @property string $to
 * @property string $deliveryTime
 * @property string $deliveryType
 * @property string $couponCode
 * @property string $comment
 * @property array $prices
 * @property Thing $thing
 * @property string $userId
 * @property string $ownerId
 * @property string $thingId
 * @property array $location
 * @property array $creditCard
 * @property int $status
 * @property array $history
 * @property string $transferCode
 * @property Collection|Review[] $reviews
 * @property Collection|Review[] $clientReviews
 * @property Collection|Review[] $ownerReviews
 * @property bool $hasReviews
 * @property bool $hasClientReviews
 * @property bool $hasOwnerReviews
 * @property ?User $user
 * @property ?User $owner
 */
class Order extends Eloquent
{
    const DELIVERY_TYPE_DELIVERY = 'delivery';
    const DELIVERY_TYPE_PICKUP = 'pickup';

    const STATUS_REQUESTED = 1;
    const STATUS_CANCELED = 2;
    const STATUS_CLIENT_APPROVED = 3;
    const STATUS_CLIENT_REJECTED = 4;
    const STATUS_OWNER_APPROVED = 5;
    const STATUS_OWNER_REJECTED = 6;
    const STATUS_PAID = 7;
    const STATUS_TRANSFERRED_TO_COURIER = 8;
    const STATUS_TRANSFERRED_TO_CLIENT = 9;
    const STATUS_RETURNED_TO_COURIER = 10;
    const STATUS_RETURNED_TO_OWNER = 11;

    const HISTORY_ACTION_STATUS_CHANGED = 1;

    /**
     * @var string
     */
    protected $collection = 'orders';

    protected $casts = ['from' => 'datetime', 'to' => 'datetime'];


    /**
     * @var bool
     */
    protected static $unguarded = true;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'ownerId');
    }

    public function thing()
    {
        return $this->belongsTo(Thing::class, 'thingId');
    }

    public static function getDeliveryTypes(): array
    {
        return [
            self::DELIVERY_TYPE_DELIVERY,
            self::DELIVERY_TYPE_PICKUP,
        ];
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id');

    }

    public function clientReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id')->where('user_id', $this->userId);

    }

    public function ownerReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'order_id')->where('user_id', $this->ownerId);

    }

    public static function getAvailableStatuses(): array
    {
        return [
            self::STATUS_REQUESTED,
            self::STATUS_CANCELED,
            self::STATUS_CLIENT_APPROVED,
            self::STATUS_CLIENT_REJECTED,
            self::STATUS_OWNER_APPROVED,
            self::STATUS_OWNER_REJECTED,
            self::STATUS_PAID,
            self::STATUS_TRANSFERRED_TO_COURIER,
            self::STATUS_TRANSFERRED_TO_CLIENT,
            self::STATUS_RETURNED_TO_COURIER,
            self::STATUS_RETURNED_TO_OWNER,
        ];
    }

    public function hideTransferCode(string $userId): Order
    {
        if (
            ($userId === $this->userId && $this->status !== self::STATUS_TRANSFERRED_TO_CLIENT)
            ||
            ($userId === $this->ownerId && $this->status !== self::STATUS_PAID)
        ) {
            $this->setHidden(['transferCode']);
        }
        return $this;
    }

    public function getHasReviewsAttribute(): bool
    {
        return $this->reviews->count() > 0;
    }

    public function getHasClientReviewsAttribute(): bool
    {
        return $this->clientReviews->count() > 0;
    }

    public function getHasOwnerReviewsAttribute(): bool
    {
        return $this->ownerReviews->count() > 0;
    }

    public function isUserOrder(string $userId): bool
    {
        return $this->userId === $userId || $this->ownerId === $userId;
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
