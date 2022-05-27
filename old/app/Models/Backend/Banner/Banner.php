<?php

namespace App\Models\Backend\Banner;

use App\Models\Backend\User\Company;
use App\Models\User;
use App\Services\UtilityService;
use App\Traits\BlamableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;


class Banner extends Model implements Auditable
{
    use Notifiable;
    use HasFactory;
    use SoftDeletes;
    use BlamableTrait;
    use \OwenIt\Auditing\Auditable;
    use HasApiTokens;
    use \Kyslik\ColumnSortable\Sortable;


    protected $table = 'banners';
    protected $guarded = ['id'];


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
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * @return BelongsTo
     */
    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    /**
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     */
    public function getBannerImageFullPathAttribute()
    {
        if(empty($this->banner_image)){
            $banner_image = url('/assets/img/static/banner1.png');
        }else {
            if (preg_match(UtilityService::$RegExUrl, $this->banner_image)) {
                $banner_image = $this->banner_image;
            } elseif (file_exists(public_path() . $this->banner_image)) {
                $banner_image = url($this->banner_image);
            } else {
                $banner_image = url('/assets/img/static/banner1.png');
            }
        }
        return $banner_image;
    }
}
