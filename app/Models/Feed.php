<?php namespace App;

use DateTimeInterface;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Relations\HasMany;

/**
 * @property string $_id
 * @property string $category
 * @property string $text
 * @property string $userId
 * @property array $images
 * @property array $location
 * @property array $address
 * @property array $feed_settings
 */
class Feed extends Eloquent {

    public const CATEGORY_ALERT = 1;
    public const CATEGORY_RECOMMEND = 2;
    public const CATEGORY_QUESTION = 3;
    public const CATEGORY_SEARCH = 4;
    public const CATEGORY_LOST_AND_FOUND = 5;

    protected $primaryKey = "_id";
    protected $connection = 'feeds';
    protected $collection = 'feeds';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    protected static $unguarded = true;

    /**
     * @return int[]
     */
    public static function getAvailableCategories(): array
    {
        return [
            self::CATEGORY_ALERT,
            self::CATEGORY_RECOMMEND,
            self::CATEGORY_QUESTION,
            self::CATEGORY_SEARCH,
            self::CATEGORY_LOST_AND_FOUND
        ];
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
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

    public function likes(): HasMany
    {
        return $this->hasMany('App\Like', 'target_id')->where('type', 'feed');
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
