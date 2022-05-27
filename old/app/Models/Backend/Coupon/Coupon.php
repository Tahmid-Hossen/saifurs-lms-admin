<?php

namespace App\Models\Backend\Coupon;

use App\Models\Backend\User\Company;
use App\Models\User;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class Coupon extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'coupons';
    protected $guarded = ['id'];

    /**
     * @return BelongsTo
     */
    public function createdBy() {
        return $this->belongsTo( User::class, 'created_by' );
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy() {
        return $this->belongsTo( User::class, 'updated_by' );
    }

    /**
     * @return BelongsTo
     */
    public function deletedBy() {
        return $this->belongsTo( User::class, 'deleted_by' );
    }

    /**
     * @return BelongsTo
     */
    public function company() {
        return $this->belongsTo( Company::class, 'company_id' );
    }
}
