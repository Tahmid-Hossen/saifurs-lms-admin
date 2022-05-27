<?php

namespace App\Models\Backend\Sale;

use App\Models\Backend\Coupon\Coupon;
use App\Models\Backend\User\Branch;
use App\Models\Backend\User\Company;
use App\Models\User;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Sale
 * @package App\Models\Backend\Sale
 */
class Sale extends Model implements Auditable
{
    use HasFactory, SoftDeletes, BlamableTrait;
    use \OwenIt\Auditing\Auditable, HasApiTokens, Notifiable, Sortable;

    /**
     * @var string
     */
    protected $table = 'sales';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = ['user_id', 'company_id', 'branch_id', 'reference_number', 'coupon_id', 'entry_date', 'customer_name', 'customer_email', 'customer_phone', 'ship_address', 'notes', 'transaction_id', 'transaction_response', 'currency', 'sub_total_amount', 'discount_type', 'discount_amount', 'shipping_cost', 'total_amount', 'online_total_amount', 'cod_total_amount', 'due_date', 'due_amount', 'payment_status', 'sale_status', 'source_type', 'created_by', 'updated_by', 'deleted_by'];

    protected $casts = [
        'entry_date' => 'datetime',
        'due_date' => 'datetime',

    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'sale_id', 'id');
    }

    /**
     * @return int
     */
    public function total_items(): int
    {
        return $this->hasMany(Item::class, 'sale_id', 'id')->count();
    }

    /**
     * @return HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'sale_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return BelongsTo
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * @return BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
