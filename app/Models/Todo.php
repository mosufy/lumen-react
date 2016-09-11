<?php
/**
 * Class Todo
 *
 * @date      4/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Todo
 */
class Todo extends Model
{
    use SoftDeletes;

    protected $table = 'todos';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    { // @codeCoverageIgnoreStart
        return $this->belongsTo('App\Models\Category');
    } // @codeCoverageIgnoreEnd

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    { // @codeCoverageIgnoreStart
        return $this->belongsTo('App\Models\User'); // @codeCoverageIgnore
    } // @codeCoverageIgnoreEnd
}
