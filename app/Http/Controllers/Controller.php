<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param array $input
     * @param string $prefix
     * @return array
     */
    public function dateRangePicker(array $input, string $prefix = ''): array
    {
        return [
            $prefix . 'start_date' => (
            isset($input[$prefix . 'start_date']) ? $input[$prefix . 'start_date'] . ' 00:00:01' : Carbon::now()->subYear(10)->format('Y-m-d') . ' 00:00:01'
            ),
            $prefix . 'end_date' => (
            isset($input[$prefix . 'end_date']) ? $input[$prefix . 'end_date'] . ' 23:59:59' : Carbon::now()->addDay('1')->format('Y-m-d') . ' 23:59:59'
            ),
            //$prefix . 'date_range' => Carbon::now()->subDays(29)->format('F d, Y') . ' - ' . Carbon::now()->format('F d, Y'),
        ];
    }

    // json data
    public function getJSONResponse( $id ) {
        return response()->json( $id );
    }
}
