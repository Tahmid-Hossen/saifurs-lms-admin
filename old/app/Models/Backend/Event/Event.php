<?php

namespace App\Models\Backend\Event;

use App\Models\Backend\User\Branch;
use App\Models\Backend\User\Company;
use App\Models\User;
use App\Services\UtilityService;
use App\Traits\BlamableTrait;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Kyslik\ColumnSortable\Sortable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;


class Event extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use Notifiable;
    use Sortable;
    use \Kyslik\ColumnSortable\Sortable;


    protected $table = 'events';
    protected $guarded = ['id'];

/*    protected $casts = [
        'event_start' => 'datetime',
        'event_end' => 'datetime'
    ];*/

    /**
     * @return BelongsTo
     */
    public function createdBy()
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
     * @return Application|UrlGenerator|string
     */
    public function getEventImageFullPathAttribute()
    {
        if (preg_match(UtilityService::$RegExUrl, $this->event_image)) {
            $event_image = $this->event_image;
        } elseif (file_exists(public_path() . $this->event_image)) {
            $event_image = url($this->event_image);
        } else {
            $event_image = url('/assets/img/static/event.jpg');
        }
        return $event_image;
    }

    /**
     * @return BelongsToMany
     */
    public function getEnrolledUsersList(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')
            ->withTimestamps()
            ->withPivot(['remarks', 'event_user_status']);
    }

    /**
     * @return int
     */
    public function getTotalRegistered(): int
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')
            ->withPivot(['remarks', 'event_user_status'])->count();
    }

    /**
     * @return array
     */
    public function getEventProgress(): string
    {
        $current_time = Carbon::now();
        $start_time = Carbon::parse($this->event_start);
        $end_time = Carbon::parse($this->event_end);
        $current_to_start_gap = $current_time->diffInMinutes($start_time, false);
        $current_to_end_gap = $current_time->diffInMinutes($end_time, false);

        //yet to start
        if ($current_to_start_gap > 0)
            return 'Not Started';
        elseif ($current_to_start_gap <= 0 && $current_to_end_gap >= 0)
            return 'Running';
        else
            return 'Ended';
    }

    /**
     * @return BelongsToMany
     */
    public function eventUserList(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id');
    }
}
