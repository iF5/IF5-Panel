<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\Repositories\Panel\UserRepository;
use App\Http\Traits\UserTrait;
use App\Services\BreadcrumbService;

class UserAdminController extends Controller implements UserInterface
{
    private $userRepository;

    private $breadcrumbService;

    use UserTrait;

    public function __construct(
        UserRepository $userRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->userRepository = $userRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return UserRepository
     */
    public function getUser()
    {
        return $this->userRepository
            ->setRole($this->getRole())
            ->setCompanyId($this->getCompanyId())
            ->setProviderId($this->getProviderId());
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return 'admin';
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return 0;
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return 0;
    }

    /**
     * @param string $location
     * @return array
     */
    public function getBreadcrumb($location = null)
    {
        return $this->breadcrumbService->push([
            'Usu&aacute;rios administradores' => route("user-{$this->getRole()}.index"),
            $location => null
        ])->get();
    }

}




