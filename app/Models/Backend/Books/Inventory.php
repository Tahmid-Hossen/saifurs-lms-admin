<?php

namespace App\Models\Backend\Books;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Class Book
 * @package App\Models\Backend\Book
 */
class Inventory extends Model
{
    use Notifiable;
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'inventories';
    protected $fillable = [
        'book_id ',
        'initial_qty',
        'increment_qty',
        'decrement_qty',
        'current_qty',
        'initial_price',
        'purchase_price',
        'sell_price',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

}
