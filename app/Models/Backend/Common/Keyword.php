<?php

namespace App\Models\Backend\Common;

use App\Models\Backend\Books\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Keyword
 * @package App\Models\Backend\Common
 */
class Keyword extends Model
{
    use HasFactory, SoftDeletes;
    use \Kyslik\ColumnSortable\Sortable;

    /**
     * @var string
     */
    protected $table = 'keywords';

    /**
     * @var string
     */
    protected $primaryKey = 'keyword_id';

    /**
     * @var string[]
     */
    protected $fillable = ['keyword_name', 'keyword_status', 'created_by', 'updated_by', 'deleted_by'];

    /**
     * @return BelongsToMany
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'keyword_book', 'book_id', 'keyword_id');
    }
}
