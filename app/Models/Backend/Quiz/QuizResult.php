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
use App\Models\Backend\Quiz\Quiz;
use App\Models\Backend\User\UserDetail;

class QuizResult extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;


    protected $table = 'quiz_results';
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
	
	public function quiz()
    {
		return $this->belongsTo(Quiz::class, 'quiz_id');
    }
	
	public function users()
    {
		return $this->belongsTo(UserDetail::class, 'user_id','user_id');
    }
	
	 public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

//->select(['first_name', 'last_name'])
  
}
