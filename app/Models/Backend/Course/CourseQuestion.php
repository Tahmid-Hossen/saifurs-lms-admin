<?php

namespace App\Models\Backend\Course;

use App\Services\UtilityService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlamableTrait;
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
use App\Models\Backend\Course\CourseChapter;
use App\Models\Backend\Course\CourseClass;

class CourseQuestion extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_questions';
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
	
	 public function questionOptions()
    {
        //return $this->belongsTo(CourseQuestionOption::class, 'question_id');
		return $this->hasMany(CourseQuestionOption::class, 'question_id','id');
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

    public function courseChapter()
    {
        return $this->belongsTo(CourseChapter::class, 'chapter_id', 'id');
    }

    public function courseClass()
    {
        return $this->belongsTo(CourseClass::class, 'class_id', 'id');
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
     * @return Application|UrlGenerator|string
     */
    public function getQuestionImageFullPathAttribute()
    {
        if(empty($this->question_image)){
            $question_image = url('/assets/img/default.png');
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->question_image)) {
                $question_image = $this->question_image;
            }elseif (file_exists( public_path() . $this->question_image)) {
                $question_image = url($this->question_image);
            } else {
                $question_image = url('/assets/img/default.png');
            }
        }
        return $question_image;
    }
}
