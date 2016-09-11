<?php
/**
 * Class Category
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 */
class Category extends Model
{
    protected $table = 'categories';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function todos()
    { // @codeCoverageIgnoreStart
        return $this->hasMany('App\Models\Todo');
    } // @codeCoverageIgnoreEnd

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    { // @codeCoverageIgnoreStart
        return $this->belongsTo('App\Models\User');
    } // @codeCoverageIgnoreEnd
}
