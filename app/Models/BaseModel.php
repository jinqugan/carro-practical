<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 *
 * @package App\Models
 *
 * @method static \Illuminate\Database\Eloquent\Builder where($column, $operator = null, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder limit($value)
 * @method static \Illuminate\Database\Eloquent\Builder offset($value)
 * @method static \Illuminate\Database\Eloquent\Builder select($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder create(array $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Builder update(array $values)
 * @method static \Illuminate\Database\Eloquent\Builder first($columns = ['*'])
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class BaseModel extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->perPage = config('constant.pagination');
    }
}
