<?php

namespace App\Models\Backend\Course;

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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class CourseBatch extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_batches';
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
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * @return BelongsToMany
     */
    public function student(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_batch_students', 'course_batch_id', 'student_id');
    }

    /**
     * @return Application|UrlGenerator|string
     */
    public function getCourseImageFullPathAttribute()
    {
        if(empty($this->course_batch_logo)){
            $course_batch_logo = url('/assets/img/default.png');
        }else{
            if (preg_match(UtilityService::$RegExUrl, $this->course_batch_logo)) {
                $course_batch_logo = $this->course_batch_logo;
            }elseif (file_exists( public_path() . $this->course_batch_logo)) {
                $course_batch_logo = url($this->course_batch_logo);
            } else {
                $course_batch_logo = url('/assets/img/default.png');
            }
        }
        return $course_batch_logo;
    }

    public function getBatchClassDayAttribute()
    {
        $batch_class_days = explode(',', $this->batch_class_days);
        $array = array();
        foreach ($batch_class_days as $batch_class_day):
            $array[$batch_class_day] = $batch_class_day;
        endforeach;
        return $array;
    }

}

