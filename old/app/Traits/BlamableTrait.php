<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait BlamableTrait
{
    public static function bootBlamableTrait()
    {

        static::creating(function (Model $model) {

            if (auth()->check()) {
                $user = auth()->user();
            } else {
                $user = User::where('mobile_number', '01614000000')->first();
            }

            $model->created_by = isset($user) ? $user->id : 1;
        });

        static::updating(function (Model $model) {

            if (auth()->check()) {
                $user = auth()->user();
            } else {
                $user = User::where('mobile_number', '01614000000')->first();
            }

            $model->updated_by = isset($user) ? $user->id : 1;

        });

        static::deleting(function (Model $model) {
            if (auth()->check()) {
                $user = auth()->user();
            } else {
                $user = User::where('email', 'admin@aleshatech-lms.com')->first();
            }

            $model->deleted_by = isset($user) ? $user->id : 1;
        });
    }
}
