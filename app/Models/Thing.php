<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Collection;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

/**
 * Class Thing
 * @package App
 * @property string $_id
 * @property string $title
 * @property string $purpose
 * @property array|null $rentPrices
 * @property bool $addToMyAssets
 * @property string|null $categoryId
 * @property string|null $subCategoryId
 * @property string|null $roomId
 * @property string|null $userId
 * @property bool $lostOrFound
 * @property array $images
 * @property string $country
 * @property string $zip
 * @property string $city
 * @property string $street
 * @property string $description
 * @property float $realCost
 * @property int $status
 * @property bool $courierDelivery
 * @property bool $freeForNeighbors
 * @property array $location
 * @property array $address
 * @property float $rating
 * @property Collection|Review[] $reviews
 */
class Thing extends Eloquent
{

    public const PURPOSE_RENT = 'rent';
    public const PURPOSE_FREE = 'free';
    public const PURPOSE_LOST = 'lost';
    public const PURPOSE_FOUND = 'found';


    public const STATUS_VISIBLE = 1;
    public const STATUS_SECRET = 2;
    public const STATUS_VISIBLE_FOR_NEIGHBORS = 3;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string
     */
    protected $collection = 'things';
    /**
     * @var bool
     */
    protected static $unguarded = true;

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'thingId');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'target_id')->where('type', Like::TYPE_THING);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'target_id')
            ->where('type', Review::TYPE_THING);
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
     * @return array
     */
    public function toArray(): array
    {
        $result = parent::toArray();

        if (isset($result['address'])) {
            $result['location'] = $result['address'];
            unset($result['address']);
        }

        return $result;
    }

    public function getRatingAttribute(): float
    {
        $rating = 0;
        foreach ($this->reviews as $review) {
            $rating += $review->rating;
        }
        if ($this->reviews->count() > 0) {
            return round($rating / $this->reviews->count(), 2);
        }

        return 0;
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
