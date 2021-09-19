<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchCoupon(Builder $query, $value)
    {
        return $query->orWhere('name', 'like', '%' . $value . '%')
            ->orWhere('code', 'like', '%' . $value . '%');
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeOfType(Builder $query, $value)
    {
        return $query->where('type', '=', $value);
    }
}
