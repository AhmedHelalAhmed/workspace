<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Variable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Variable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Variable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variable whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variable whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Variable whereValue($value)
 *
 * @mixin \Eloquent
 */
class Variable extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'note',
    ];
}
