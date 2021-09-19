<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 *
 * @mixin Builder
 * @package App
 */
class Language extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchName(Builder $query, $value)
    {
        return $query->where('name', 'like', '%'.$value.'%');
    }
}
