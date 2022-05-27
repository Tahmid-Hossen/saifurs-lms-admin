<?php


namespace App\Services\Backend\Setting;


use App\Repositories\Backend\Setting\VendorMeetingRepository;
use App\Services\FileUploadService;
use App\Services\UtilityService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class VendorMeetingService
{
    /**
     * @var VendorMeetingRepository
     */
    private $vendorMeetingRepository;
    /**
     * @var FileUploadService
     */
    private $fileUploadService;

    /**
     * VendorMeetingService constructor.
     * @param VendorMeetingRepository $vendorMeetingRepository
     * @param FileUploadService $fileUploadService
     */
    public function __construct(VendorMeetingRepository $vendorMeetingRepository, FileUploadService $fileUploadService)
    {
        $this->vendorMeetingRepository = $vendorMeetingRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * @param array $input
     * @return false|mixed
     */
    public function storeVendorMeeting(array $input)
    {
        $date_range = explode( ' - ', $input['vendor_meeting_duration'] );

        $vendor_meeting_start = $date_range[0] ?? null;
        $vendor_meeting_end = $date_range[1] ?? null;
        if ( $vendor_meeting_start == $vendor_meeting_end ) {
            $currentDate = strtotime( $vendor_meeting_start );
            $futureDate = $currentDate + ( 60 * 5 );
            $vendor_meeting_end = date( "Y-m-d H:i:s", $futureDate );
        }

        $input['vendor_meeting_start_time'] = $vendor_meeting_start;
        $input['vendor_meeting_end_time'] = $vendor_meeting_end;

        try {
            return $this->vendorMeetingRepository->create($input);
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return false|mixed
     */
    public function updateVendorMeeting($input, $id)
    {
        $date_range = explode( ' - ', $input['vendor_meeting_duration'] );

        $vendor_meeting_start = $date_range[0] ?? null;
        $vendor_meeting_end = $date_range[1] ?? null;
        if ( $vendor_meeting_start == $vendor_meeting_end ) {
            $currentDate = strtotime( $vendor_meeting_start );
            $futureDate = $currentDate + ( 60 * 5 );
            $vendor_meeting_end = date( "Y-m-d H:i:s", $futureDate );
        }

        $input['vendor_meeting_start_time'] = $vendor_meeting_start;
        $input['vendor_meeting_end_time'] = $vendor_meeting_end;

        try {
            $vendor = $this->vendorMeetingRepository->find($id);
            $this->vendorMeetingRepository->update($input, $id);
            return $vendor;
        } catch (ModelNotFoundException $e) {
           \Log::error('Vendor Meeting not found');
        } catch (\Exception $e) {
           \Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function showVendorMeetingByID($id)
    {
        return $this->vendorMeetingRepository->find($id);
    }

    /**
     * @param $input
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function ShowAllVendorMeeting($input): \Illuminate\Database\Eloquent\Builder
    {
        return $this->vendorMeetingRepository->VendorMeetingFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteVendorMeeting($id)
    {
        return $this->vendorMeetingRepository->delete($id);
    }

    /**
     * @param $input
     * @return string|null
     */
    public function vendorMeetingLogo($input): ?string
    {
        $data['image'] = $input->file('vendor_meeting_logo');
        $data['image_name'] = 'vendor_meeting_logo_'.$input['vendor_meeting_id']."_".date('Y_m_d_h_i_s');
        $data['destination'] = UtilityService::$imageUploadPath['vendor_meeting_logo'];
        $data['width'] = UtilityService::$vendorMeetingLogoSize['width'];
        $data['height'] = UtilityService::$vendorMeetingLogoSize['height'];
        return $this->fileUploadService->savePhoto($data);
    }
}
