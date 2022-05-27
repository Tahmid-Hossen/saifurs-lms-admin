<?php

namespace App\Models\Backend\Sale;

use App\Interfaces\ItemInterface;
use App\Models\User;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Item
 * @package App\Models\Backend\Sale
 */
class Item extends Model implements ItemInterface, Auditable
{
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    /**
     * @var string
     */
    protected $table = 'sale_items';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var string[]
     */
    protected $fillable = ['sale_id', 'item_id', 'item_path', 'item_description', 'item_extra', 'delivery_type', 'price_amount', 'quantity', 'sub_total_amount', 'discount_amount', 'total_amount', 'created_by', 'updated_by', 'deleted_by'];

    /**
     * @return BelongsTo
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id', 'id');
    }


    /**
     * @return mixed
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->item_description;
    }


    public function getItemNameAttribute(): ?string
    {
        $model = $this->item_path::withTrashed()->find($this->item_id);
        return $model->item_name;
    }

    /**
     * @return string
     */
    public function getItemTypeAttribute(): ?string
    {
        $model = $this->item_path::withTrashed()->find($this->item_id);
        return $model->item_type;
    }


    /**
     * Extra information about Item unique data will be store here
     *
     * Convert Json string to Array
     * access as $item->item_extra_info_array
     * @return array
     */
    public function getItemExtraInfoArrayAttribute(): array
    {
        $extraArray = [];
        try {
            $extraStr = $this->item_extra;
            if ((strlen($extraStr) > 0) && \Utility::validJson($extraStr))
                $extraArray = json_decode($extraStr, true);
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
        } finally {
            return is_array($extraArray) ? $extraArray : [];
        }
    }

    /**
     * @return mixed
     */
    public function getItemSourceAttribute()
    {
        return $this->item_path::withTrashed()->find($this->item_id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
