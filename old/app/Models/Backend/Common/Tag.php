<?php

namespace App\Models\Backend\Common;

use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Passport\HasApiTokens;
use App\Models\Backend\Course\Course;

class Tag extends Model implements Auditable
{
    use HasFactory, SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    /**
     * @var string
     */
    protected $table = 'tags';
    protected $guarded = ['id'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_tag', 'course_id', 'tag_id');
    }

}
