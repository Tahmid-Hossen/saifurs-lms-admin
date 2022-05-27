<?php

namespace App\Services\Backend\Event;

use App\Repositories\Backend\Event\EventRegisterRepository;
use App\Repositories\Backend\Event\EventRepository;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

/**
 * Class EventRegisterService
 * @package App\Services\Backend\Event
 */
class EventRegisterService
{
    /**
     * @var EventRegisterRepository
     */
    private $eventRegisterRepository;
    /**
     * @var EventRepository
     */
    private $eventRepository;

    /**
     * EventRegisterService constructor.
     * @param EventRepository $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param $input
     * @return array
     */
    public function formatInvitationRequest($input): array
    {
        $users = [];
        if (!empty($input)) {
            foreach ($input as $user) {
                $users[$user['user_id']] = [
                    'event_user_status' => $user['event_user_status'],
                    'remarks' => $user['remarks']
                ];
            }
        }

        return $users;
    }

    /**
     * Get all EventRegisters
     *
     * @param array $filters
     *
     * @return LengthAwarePaginator
     */
    public function getAllEventRegisteredUser(array $filters): LengthAwarePaginator
    {
        $with = [];

        return $this->eventRegisterRepository
            ->getEventRegisterWith($with, $filters)
            ->paginate(\Utility::$displayRecordPerPage);
    }

    /**
     * @param array $input
     *
     * @return mixed
     */
    public function storeEventRegister(array $input)
    {
        try {
            $event_id = $input["event_id"];
            $invites = $this->formatInvitationRequest($input['invitation']);
            $event = $this->eventRepository->findBy('id', $event_id);
            return $this->eventRepository->attachUsers($event, $invites);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        return ['status' => false, 'message' => 'Something went wrong'];
    }

    /**
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function updateEventRegister($input, $id)
    {
        try {
            $invites = $this->formatInvitationRequest($input['invitation']);
            $event = $this->eventRepository->findBy('id', $id);
            return $this->eventRepository->syncUsers($event, $invites);
        } catch (ModelNotFoundException $e) {
            Log::error('EventRegister not found');
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function showEventRegisterByID($id)
    {
        return $this->eventRegisterRepository->find($id);
    }

    /**
     * @param $input
     * @return mixed
     */
    public function ShowAllEventRegister($input)
    {
        return $this->eventRegisterRepository->EventRegisterFilterData($input);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function deleteEventRegister($id)
    {
        return $this->eventRegisterRepository->delete($id);
    }
}
