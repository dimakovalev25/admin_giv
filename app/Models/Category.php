<?php

namespace App\Models;

use App\Thing;
use DateTimeInterface;
use MongoDB\Laravel\Eloquent\Model as Eloquent;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

/**
 * @property string $_id
 * @property string $shortname
 */
class Category extends Eloquent
{

    protected $collection = 'categories';
    protected static $unguarded = true;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @return HasMany
     */
    public function things(): HasMany
    {
        return $this->hasMany(Thing::class, 'subCategoryId')->orderBy('created_at', 'DESC');
    }

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(__CLASS__, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(__CLASS__, 'parent_id');
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


//    public function goods()
//    {
//        return $this->hasMany(Good::class);
//    }
//
//    public function rexes()
//    {
//        return $this->hasMany('App\Rex');
//    }
//
//    public function boards()
//    {
//        return $this->hasMany('App\Board');
//    }
//
//    public function linkedBrands()
//    {
//        return $this->hasMany('App\BrandCatLink');
//    }
//
//    public function getTop3Attribute()
//    {
//        $result = [];
//        //dd($cat);
//        for ($i = 1; $i <= 3; $i++) {
//            if ($this->{'topfeature' . $i}) {
//                $fid = $this->{'topfeature' . $i};
//                $a = [];
//                foreach ($this->groups as $grp) {
//                    //$grp = array_search($cat['topfeature'.$i], $cat->groups);
//                    //dd($grp);
//                    if (isset($grp['features'][$fid])) {
//                        $f = $grp['features'][$fid];
//                        $a['id'] = $fid;
//                        $a['description'] = isset($f['description']) ? $f['description'] : '';
//                        $a['helper'] = isset($f['helper']) ? $f['helper'] : '';
//                        if ($f['type'] == 'ENUM' || $f['type'] == 'MENUM') {
//                            $en = Enum::find($f['enum']);
//                            $a['values'] = $en ? $en->values : [];
//                        }
//                    }
//                }
//                $result[] = $a;
//            }
//        }
//        //dd($result);
//        return $result;
//    }
//
//    public function getDetailsAttribute()
//    {
//        $result = $this->toArray();
//        unset($result['parent']);
//        $result['id'] = $result['_id'];
//        $result['parent_id'] = isset($result['parent_id']) ? (string)$result['parent_id'] : 0;
//        if (isset($result['images']['1']['proto'])) {
//            if (substr($result['images']['1']['host'], 0, 4) != 'http') {
//                $result['images']['1']['host'] = $result['images']['1']['proto'] . '://' . $result['images']['1']['host'];
//            }
//            unset($result['images']['1']['proto']);
//        }
//
//        return $result;
//    }
}
