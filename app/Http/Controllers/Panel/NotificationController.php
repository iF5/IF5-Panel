<?php

namespace App\Http\Controllers\Panel;


use App\Repositories\Panel\NotificationRepository;

class NotificationController
{

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    private $notifications = [
        'providerPendency',
        'employeePendency'
    ];

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @return mixed
     */
    public function load()
    {
        $data = ['total' => 0, 'items' => []];

        foreach ($this->notifications as $notification) {
            $notificationMethod = $this->$notification();
            //if ($notificationMethod['total'] > 0) {
                $data['total'] = ($data['total'] + $notificationMethod['total']);
                $data['items'][] = $notificationMethod;
            //}
        }

        //return \Response::json($data);
        return $data;
    }

    /**
     * @return array
     */
    protected function providerPendency()
    {
        return [
            'link' => route('pendency.index', ['source' => 'provider']),
            'label' => 'Pend&ecirc;ncias de prestadores de servi&ccedil;os',
            'total' => $this->notificationRepository->countByStatus('providers_has_companies')
        ];
    }

    /**
     * @return array
     */
    protected function employeePendency()
    {
        return [
            'link' => route('pendency.index', ['source' => 'employee']),
            'label' => 'Pend&ecirc;ncias de funcion&aacute;rios',
            'total' => $this->notificationRepository->countByStatus('employees')
        ];
    }

}
