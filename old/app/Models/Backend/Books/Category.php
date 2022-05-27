<?php

namespace App\Models\Backend\Books;

use App\Models\Backend\User\Company;
use App\Models\User;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Category
 * @package App\Models\Backend\Book
 */
class Category extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    /**
     * @var string
     */
    protected $table = 'book_categories';

    /**
     * @var string
     */
    protected $primaryKey = 'book_category_id';

    /**
     * @var string[]
     */
    protected $fillable = ['company_id','book_category_name', 'book_category_status', 'created_by', 'updated_by', 'deleted_by'];

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
    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * @return HasMany
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'book_category_id', 'book_category_id');
    }


    /**
     * @return HasMany
     */
    public function ebooks(): HasMany
    {
        return $this->hasMany(EBook::class, 'book_category_id', 'book_category_id');
    }

    /**
     * @return int
     */
    public function totalRelatedBooks(): int
    {
        return $this->hasMany(Book::class, 'book_category_id', 'book_category_id')->count();
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
