<?php

namespace App\Models\Backend\Quiz;

use App\Models\Backend\Course\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BlamableTrait;
use App\Models\User;
use App\Models\Backend\User\Company;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\Backend\Course\CourseQuestion;

class QuizUserAnswer extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;


    protected $table = 'quiz_user_answer';
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
   /* public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }*/
	
	public function question()
    {
        //return $this->belongsTo(CourseQuestion::class, 'quiz_id');
		return $this->hasMany(CourseQuestion::class, 'quiz_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

}
