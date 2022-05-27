<?php

namespace App\Models\Backend\Course;

use App\Models\Backend\User\Branch;
use App\Services\UtilityService;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\User\Company;
use App\Models\Backend\Course\CourseCategory;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
use App\Models\Backend\User\UserDetail;

class CourseSubCategory extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_sub_category';
    protected $guarded = ['id'];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getCourseSubCategoryImageFullPathAttribute()
    {
        if (preg_match(UtilityService::$RegExUrl, $this->course_sub_category_image)) {
            $course_sub_category_image = $this->course_sub_category_image;
        }elseif (file_exists( public_path() . $this->course_sub_category_image)) {
            $course_sub_category_image = url($this->course_sub_category_image);
        } else {
            $course_sub_category_image = url('/assets/img/default.png');
        }
        return $course_sub_category_image;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseChildCategory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseChildCategory::class, 'course_sub_category_id');
    }
}
