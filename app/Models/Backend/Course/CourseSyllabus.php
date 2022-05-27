<?php

namespace App\Models\Backend\Course;

use App\Services\UtilityService;
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
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\courseClass;
use App\Models\Backend\User\Company;

class CourseSyllabus extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_syllabuses';
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getSyllabusFileFullPathAttribute()
    {
        if(empty($this->syllabus_file)){
            $syllabus_file = null;
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->syllabus_file)) {
                $syllabus_file = $this->syllabus_file;
            }elseif (file_exists( public_path() . $this->syllabus_file)) {
                $syllabus_file = url($this->syllabus_file);
            } else {
                $syllabus_file = null;
            }
        }
        return $syllabus_file;
    }

}
