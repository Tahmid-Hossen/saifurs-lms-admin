<?php

namespace App\Models\Backend\User;

use App\Models\Backend\Blog\Blog;
use App\Models\Backend\Course\Course;
use App\Models\Backend\Course\CourseCategory;
use App\Models\Backend\Course\CourseSubCategory;
use App\Models\Backend\Course\CourseChildCategory;
use App\Models\Backend\Event\Event;
use App\Models\Backend\Setting\City;
use App\Models\Backend\Setting\Country;
use App\Models\Backend\Setting\State;
use App\Models\User;
use App\Services\UtilityService;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

class Company extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;

    //@TODO Arif Vai, Each Company should have a field, where they can put experienced years
    protected $table = 'companies';
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
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    /**
     * @return BelongsTo
     */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    /**
     * @return BelongsTo
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * @return HasMany
     */
    public function userDetails(): HasMany
    {
        return $this->hasMany(UserDetail::class, 'company_id');
    }

    /**
     * @return HasMany
     */
    public function courseCategories(): HasMany
    {
        return $this->hasMany(CourseCategory::class, 'company_id');
    }

    /**
     * @return HasMany
     */
    public function courseSubCategories(): HasMany
    {
        return $this->hasMany(CourseSubCategory::class, 'company_id');
    }

    /**
     * @return HasMany
     */
    public function courseChildCategories(): HasMany
    {
        return $this->hasMany(CourseChildCategory::class, 'company_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function course(): HasMany
    {
        return $this->hasMany(Course::class, 'company_id');
    }

    /**
     * @return HasMany
     */
    protected function events(): HasMany
    {
        return $this->hasMany(Event::class, 'company_id');
    }

    /**
     * @return HasMany
     */
    protected function blog(): HasMany
    {
        return $this->hasMany(Blog::class, 'company_id');
    }

    /**
     * @return mixed
     */
    public function getCompanyLogoFullPathAttribute()
    {
        if (preg_match(UtilityService::$RegExUrl, $this->company_logo)) {
            $company_logo = $this->company_logo;
        }elseif (file_exists( public_path() . $this->company_logo)) {
            $company_logo = url($this->company_logo);
        } else {
            $company_logo = url('/assets/img/default.png');
        }
        return $company_logo;
    }
}
