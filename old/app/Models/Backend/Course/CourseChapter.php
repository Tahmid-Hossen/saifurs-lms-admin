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

class CourseChapter extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_chapters';
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseClass(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseClass::class, 'chapter_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseActiveClass(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseClass::class, 'chapter_id', 'id')->where('class_status', '=', 'ACTIVE');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courseAssignment(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CourseAssignment::class, 'course_id', 'id');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getChapterImageFullPathAttribute()
    {
        if(empty($this->chapter_image)){
            $chapter_image = url('/assets/img/default.png');
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->chapter_image)) {
                $chapter_image = $this->course_image;
            }elseif (file_exists( public_path() . $this->chapter_image)) {
                $chapter_image = url($this->chapter_image);
            } else {
                $chapter_image = url('/assets/img/default.png');
            }
        }
        return $chapter_image;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getChapterFileFullPathAttribute()
    {
        if(empty($this->chapter_file)){
            $chapter_file = null;
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->chapter_file)) {
                $chapter_file = $this->chapter_file;
            }elseif (file_exists( public_path() . $this->chapter_file)) {
                $chapter_file = url($this->chapter_file);
            } else {
                $chapter_file = null;
            }
        }
        return $chapter_file;
    }

}
