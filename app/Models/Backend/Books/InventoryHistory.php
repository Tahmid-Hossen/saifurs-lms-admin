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
class InventoryHistory extends Model
{
    use Notifiable;
    use SoftDeletes;
    use \Kyslik\ColumnSortable\Sortable;

    /**
     * @var string
     */
    protected $table = 'inventory_histories';
    protected $fillable = [
        'book_id ',
        'qty',
        'purchase_price',
        'sell_price',
        'remark',
        'stock_action',
        'vendor_name',
        'vendor_contact',
        'vendor_address',
        'date',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

}
