<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $description
 * @property string $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Gist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Gist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Gist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gist whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gist whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Gist whereDescription($value)
 *
 * @mixin \Eloquent
 */
class Gist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'link',
    ];
}
