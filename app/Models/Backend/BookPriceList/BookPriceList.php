<?php

namespace App\Models\Backend\BookPriceList;

use App\Models\User;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class BookPriceList extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;
    protected $table = 'book_price_lists';

    protected $fillable = ['book_name', 'cover_price','retail_price','wholesale','status'];



    /**
     * @return BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy()
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


    /*
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;

    protected $guarded = ['id'];


    /**
     * @return BelongsTo
     */
    /*public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }*/

    /**
     * @return BelongsTo
     */
   /* public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }*/

    /**
     * @return BelongsTo
     */
    /*public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }*/
}
