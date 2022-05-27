<?php

namespace App\Models;

use App\Models\Backend\Books\Book;
use App\Models\Backend\Course\CourseBatch;
use App\Models\Backend\User\UserDetail;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;
    use HasApiTokens;
    use BlamableTrait;
    use \Kyslik\ColumnSortable\Sortable;

    protected $table = 'users';
    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'username',
        'mobile_number',
        'force_reset',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function userDetails(): HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function courseBatch(): BelongsToMany
    {
        return $this->belongsToMany(CourseBatch::class, 'course_batch_students', 'student_id', 'course_batch_id');
    }

    /**
     * Users who already purchased this book
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_user', 'book_id', 'user_id');
    }
}
