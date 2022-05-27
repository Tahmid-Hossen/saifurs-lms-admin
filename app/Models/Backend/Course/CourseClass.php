<?php

namespace App\Models\Backend\Course;

use App\Services\UtilityService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
use App\Models\Backend\User\UserDetail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Backend\User\Branch;
use App\Models\Backend\User\Company;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\Course\CourseSubCategory;
use App\Models\Backend\Course\CourseChildCategory;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseBatch;
use App\Models\Backend\Course\CourseChapter;

class CourseClass extends Model  implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_classes';
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id', 'id');
    }

    public function courseSubCategory()
    {
        return $this->belongsTo(CourseSubCategory::class, 'course_sub_category_id', 'id');
    }

    public function courseChildCategory()
    {
        return $this->belongsTo(CourseChildCategory::class, 'course_child_category_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function courseBatch()
    {
        return $this->belongsTo(Course::class, 'batch_id', 'id');
    }

    public function courseChapter()
    {
        return $this->belongsTo(CourseChapter::class, 'chapter_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getClassImageFullPathAttribute()
    {
        if(empty($this->class_image)){
            $class_image = url('/assets/img/default.png');
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->class_image)) {
                $class_image = $this->class_image;
            }elseif (file_exists( public_path() . $this->class_image)) {
                $class_image = url($this->class_image);
            } else {
                $class_image = url('/assets/img/default.png');
            }
        }
        return $class_image;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getClassFileFullPathAttribute()
    {
        if(empty($this->class_file)){
            $class_file = null;
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->class_file)) {
                $class_file = $this->class_file;
            }elseif (file_exists( public_path() . $this->class_file)) {
                $class_file = url($this->class_file);
            } else {
                $class_file = null;
            }
        }
        return $class_file;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string|null
     */
    public function getClassVideoFullPathAttribute()
    {
        if(empty($this->class_video)){
            $class_video = null;
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->class_video)) {
                $class_video = $this->class_video;
            }elseif (file_exists( public_path() . $this->class_video)) {
                $class_video = url($this->class_video);
            } else {
                $class_video = null;
            }
        }
        return $class_video;
    }

    /**
     * @return HasMany
     */
    public function courseProgress(): HasMany
    {
        return $this->hasMany(CourseProgress::class, 'course_class_id', 'id');
    }

    /**
     * @param $student_id
     * @return int
     */
    public function courseProgressWithUser($student_id): int
    {
        return $this->hasMany(CourseProgress::class, 'course_class_id')
            ->where('student_id', $student_id)
            ->count();
    }
}
