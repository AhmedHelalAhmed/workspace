<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * @property int $id
 * @property int $purchase_id
 * @property int $product_id
 * @property int $amount
 * @property int $price
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Purchase $purchase
 *
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase wherePurchaseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductPurchase whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ProductPurchase extends Pivot
{
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
