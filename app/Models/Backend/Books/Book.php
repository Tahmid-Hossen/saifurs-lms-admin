<?php

namespace App\Models\Backend\Books;

use App\Interfaces\ItemInterface;
use App\Models\Backend\Common\Keyword;
use App\Models\Backend\User\Branch;
use App\Models\Backend\User\Company;
use App\Models\User;
use App\Services\UtilityService;
use App\Traits\BlamableTrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Class Book
 * @package App\Models\Backend\Book
 */
class Book extends Model implements Auditable, ItemInterface
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
    protected $table = 'books';

    /**
     * @var string
     */
    protected $primaryKey = 'book_id';

    /**
     * @var string[]
     */
    protected $fillable = [
        'company_id',
        'branch_id',
        'book_name',
        'edition',
        'publisher',
        'author',
        'author_info',
        'contributor',
        'book_description',
        'book_category_id',
        'country',
        'language',
        'publish_date',
        'isbn_number',
        'photo',
        'file',
        'pages',
        'is_sellable',
        'book_price',
		'quantity',
        'discount_price',
        'special_price',
        'ragular_price_flag',
        'special_price_flag',
        'currency',
        'is_ebook',
        'ebook_type_id',
        'storage_path',
        'book_status',
        'created_by',
        'updated_by',
        'deleted_by'
    ];


    protected $casts = [
        'publish_date' => 'datetime',
        'photo' => 'array'
    ];

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
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'book_category_id', 'book_category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function keywords(): BelongsToMany
    {
        return $this->belongsToMany(Keyword::class, 'keyword_book', 'book_id', 'keyword_id');
    }

    /**
     * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return BelongsTo
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(EBookType::class, 'ebook_type_id', 'ebook_type_id');
    }

    /**
     * @return array
     */
    public function getPhotoFullPathAttribute(): array
    {
        $photo = [];
        if (empty($this->photo)) {
            $photo[] = url('/assets/img/static/book.jpg');
        } else {
            foreach ($this->photo as $tempPhoto):
                if (preg_match(UtilityService::$RegExUrl, $tempPhoto)) {
                    $photo[] = $tempPhoto;
                } elseif (file_exists(public_path($tempPhoto)))
                    $photo[] = url('/public'.$tempPhoto);
                else
                    $photo[] = url('/assets/img/static/book.jpg');
            endforeach;
        }

        return $photo;
    }

    /**
     * @return HasMany
     */
    public function bookRatingComment(): HasMany
    {
        return $this->hasMany(BookRatingComment::class, 'book_id', 'book_id');
    }

    /**
     * @return HasMany
     */
    public function bookRatingCommentWithApproved(): HasMany
    {
        return $this->hasMany(BookRatingComment::class, 'book_id', 'book_id')->where('is_approved', 'YES');
    }

    /**
     * @return int
     */
    public function getBookTotalCommentAttribute(): int
    {
        return $this->bookRatingComment()->count();
    }

    /**
     * @return float|int
     */
    public function getBookRatingPointAttribute()
    {
        $rating = $this->bookRatingComment()->sum('book_rating');
        $total = $this->bookRatingComment()->count();
        $result = 0;
        if ($rating > 0 && $total > 0):
            $result = $rating / $total;
        endif;
        return $result;
    }

    /**
     * @return HasMany
     */
    public function bookRatingGroup(): HasMany
    {
        return $this->hasMany(BookRatingComment::class, 'book_id', 'book_id')
            ->select([\DB::raw('COUNT(CEIL(book_rating_comments.book_rating)) AS total_book_rating_stars'), \DB::raw('CONCAT(CEIL(book_rating_comments.book_rating), "_Star") AS text_book_rating_stars')])
            ->groupBy('book_rating_comments.book_rating');
        //->where('course_ratings.course_rating_status', Constants::$user_active_status);
    }


    /**
     * @return string|null
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->book_description;
    }


    public function getItemNameAttribute(): ?string
    {
        $name = $this->book_name;
        if (!empty($this->edition) && mb_strlen($this->edition) > 1) {
            $name .= ' - ' . $this->edition;
        }
        return $name;
    }

    public function getItemTypeAttribute(): ?string
    {
        return ($this->is_ebook == 'YES') ? 'EBook' : 'Book';
    }

    /**
     * Users who already purchased this book
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'book_user', 'book_id', 'user_id')->withTimestamps();
    }

    /**
     */
    public function getItemSourceAttribute()
    {
        return $this;
    }

    public function getStoragePathFullPathAttribute()
    {
        if (empty($this->storage_path)) {
            $storage_path = null;
        } else {
            if (preg_match(UtilityService::$RegExUrl, $this->storage_path)) {
                $storage_path = $this->storage_path;
            } elseif (file_exists(public_path() . $this->storage_path)) {
                $storage_path = url($this->storage_path);
            } else {
                $storage_path = null;
            }
        }
        return $storage_path;
    }

    public function getFileFullPathAttribute()
    {
        if (empty($this->file)) {
            $file_path = null;
        } else {
            if (preg_match(UtilityService::$RegExUrl, $this->file)) {
                $file_path = $this->file;
            } elseif (file_exists(public_path() . $this->file)) {
                $file_path = url('/public'.$this->file);
            } else {
                $file_path = null;
            }
        }
        return $file_path;
    }
}
