<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Interfaces\UserInterface;
use App\Repositories\Panel\CompanyRepository;
use App\Repositories\Panel\ProviderRepository;
use App\Repositories\Panel\UserRepository;
use App\Http\Traits\UserTrait;
use App\Services\BreadcrumbService;

class UserProviderController extends Controller implements UserInterface
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CompanyRepository
     */
    private $companyRepository;

    /**
     * @var ProviderRepository
     */
    private $providerRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;

    /**
     *
     */
    use UserTrait;

    public function __construct(
        UserRepository $userRepository,
        CompanyRepository $companyRepository,
        ProviderRepository $providerRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
        $this->providerRepository = $providerRepository;
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
        return 'provider';
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return (\Session::has('companyId')) ? \Session::get('companyId') : \Auth::user()->companyId;
    }

    /**
     * @return int
     */
    public function getProviderId()
    {
        return (\Session::has('providerId')) ? \Session::get('providerId') : \Auth::user()->providerId;
    }

    /**
     * @param int $companyId
     * @param int $providerId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function identify($companyId, $providerId)
    {
        \Session::put('companyId', $companyId);
        \Session::put('providerId', $providerId);
        return redirect()->route("user-{$this->getRole()}.index");
    }

    /**
     * @return array
     */
    public function getBreadcrumb()
    {
        $companyName = $this->companyRepository->getNameById($this->getCompanyId());
        $providerName = $this->providerRepository->getNameById($this->getProviderId());

        return $this->breadcrumbService
            ->add('Empresas', 'company.index')
            ->add("{$companyName} - Prestadores de serviços", 'provider.index')
            ->add("{$providerName} - Usu&aacute;rios", null, true)
            ->get();
    }

}

