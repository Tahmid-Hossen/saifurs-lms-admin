<?php

namespace App\Models\Backend\Course;

use App\Models\Backend\User\Branch;
use App\Services\UtilityService;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\User\Company;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
use App\Models\Backend\User\UserDetail;

class CourseCategory extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_category';
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
    public function branch(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getCourseCategoryImageFullPathAttribute()
    {
        if (preg_match(UtilityService::$RegExUrl, $this->course_category_image)) {
            $course_category_image = $this->course_category_image;
        }elseif (file_exists( public_path() . $this->course_category_image)) {
            $course_category_image = url($this->course_category_image);
        } else {
            $course_category_image = url('/assets/img/default.png');
        }
        return $course_category_image;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseSubCategory(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseSubCategory::class, 'course_category_id');
    }
}
