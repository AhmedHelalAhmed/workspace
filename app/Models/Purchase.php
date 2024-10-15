<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $supplier_id
 * @property int $total
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductPurchase> $purchaseProducts
 * @property-read int|null $purchase_products_count
 * @property-read \App\Models\Supplier $supplier
 *
 * @method static \Database\Factories\PurchaseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Purchase extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'notes',
        'total',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products(): BelongsToMany
    {
        return $this
            ->belongsToMany(Product::class)
            ->withPivot('amount', 'price', 'notes')
            ->withTimestamps()
            ->withTrashed();
    }

    public function purchaseProducts(): HasMany
    {
        return $this->hasMany(ProductPurchase::class);
    }
}
