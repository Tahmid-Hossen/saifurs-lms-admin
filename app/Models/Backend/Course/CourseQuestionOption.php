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

class CourseQuestionOption extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'course_question_options';
    protected $guarded = ['id'];

    public function quiz()
    {
        return $this->belongsTo(CourseQuestion::class, 'question_id', 'id');
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
	
}
