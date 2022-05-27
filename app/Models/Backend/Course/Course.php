<?php

namespace App\Models\Backend\Course;

use App\Interfaces\ItemInterface;
use App\Models\Backend\Common\Tag;
use App\Models\Backend\Setting\VendorMeeting;
use App\Models\Backend\User\Company;
use App\Models\Backend\User\Branch;
use App\Models\User;
use App\Services\UtilityService;
use App\Support\Configs\Constants;
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

class Course extends Model implements Auditable, ItemInterface
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course';
    protected $guarded = ['id'];

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
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return BelongsTo
     */

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * @return BelongsTo
     */
    public function courseCategory(): BelongsTo
    {
        return $this->belongsTo(CourseCategory::class, 'course_category_id');
    }

    /**
     * @return BelongsTo
     */
    public function courseSubCategory(): BelongsTo
    {
        return $this->belongsTo(CourseSubCategory::class, 'course_sub_category_id');
    }

    /**
     * @return BelongsTo
     */
    public function courseChildCategory(): BelongsTo
    {
        return $this->belongsTo(CourseChildCategory::class, 'course_child_category_id');
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'course_tag', 'course_id', 'tag_id');
    }

    /**
     * @return HasMany
     */
    public function courseComment(): HasMany
    {
        return $this->hasMany(CourseRating::class, 'course_id');
    }

    /**
     * @return HasMany
     */
    public function chapters(): HasMany
    {
        return $this->hasMany(CourseChapter::class, 'course_id')->where('chapter_status','ACTIVE');
    }

    /**
     * @return HasMany
     */
    public function classes(): HasMany
    {
        return $this->hasMany(CourseClass::class, 'course_id');
    }

    /**
     * @return HasMany
     */
    public function syllabuses(): HasMany
    {
        return $this->hasMany(CourseSyllabus::class, 'course_id')->where('syllabus_status','ACTIVE');
    }

    /**
     * @return HasMany
     */
    public function learns(): HasMany
    {
        return $this->hasMany(CourseLearn::class, 'course_id')->where('learn_status','ACTIVE');
    }

    /**
     * @return HasMany
     */
    public function batches(): HasMany
    {
        return $this->hasMany(CourseBatch::class, 'course_id');
    }

    /**
     * @return int
     */
    public function getCourseTotalCommentAttribute(): int
    {
        return $this->courseComment()->count();
    }

    /**
     * @return float|int
     */
    public function getCourseRatingPointAttribute()
    {
        $rating = $this->courseComment()->sum('course_rating_stars');
        $total = $this->courseComment()->count();
        $result = 0;
        if ($rating > 0 && $total > 0):
            $result = \CHTML::numberFormat($rating / $total);
        endif;
        return $result;
    }

    /**
     * @return Application|UrlGenerator|string
     */
    public function getCourseImageFullPathAttribute()
    {
        if (empty($this->course_image)) {
            $course_image = url('/assets/img/static/course.jpg');
        } else {
            if (preg_match(UtilityService::$RegExUrl, $this->course_image)) {
                $course_image = '/public/upload/images/course_image/'.$this->course_image;
            } elseif (file_exists(public_path() .'/upload/images/course_image/'. $this->course_image)) {
                $course_image = url('/public/upload/images/course_image/'.$this->course_image);
            } else {
                $course_image = url('/assets/img/static/course.jpg');
            }
        }
        return $course_image;
    }

    /**
     * @return Application|UrlGenerator|string
     */
    public function getCourseVideoFullPathAttribute()
    {
        if (empty($this->course_video)) {
            $course_image = null;
        } else {
            if (preg_match(UtilityService::$RegExUrl, $this->course_video)) {
                $course_image = $this->course_video;
            } elseif (file_exists(public_path() . $this->course_video)) {
                $course_image = url($this->course_video);
            } else {
                $course_image = null;
            }
        }
        return $course_image;
    }

    /**
     * @return HasMany
     */
    public function courseRatingGroup(): HasMany
    {
        return $this->hasMany(CourseRating::class, 'course_id')
            ->select([\DB::raw('COUNT(CEIL(course_ratings.course_rating_stars)) AS total_course_rating_stars'), \DB::raw('CONCAT(CEIL(course_ratings.course_rating_stars), "_Star") AS text_course_rating_stars')])
            ->groupBy('course_ratings.course_rating_stars');
        //->where('course_ratings.course_rating_status', Constants::$user_active_status);
    }

    /**
     * @return HasMany
     */
    public function courseMeeting(): HasMany
    {
        return $this->hasMany(VendorMeeting::class, 'course_id');
    }

    /**
     * @return mixed
     */
    public function getDescriptionAttribute(): ?string
    {
        return $this->course_short_description;
    }

    /**
     * @return mixed
     */
    public function getItemNameAttribute(): ?string
    {
        return $this->course_title;
    }

    public function getItemTypeAttribute(): ?string
    {
        return 'Course';
    }

    /**
     */
    public function getItemSourceAttribute()
    {
        return $this;
    }
}
