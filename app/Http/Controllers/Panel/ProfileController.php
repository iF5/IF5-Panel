<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Repositories\Panel\UserRepository;
use App\Services\BreadcrumbService;

class ProfileController extends Controller
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var BreadcrumbService
     */
    private $breadcrumbService;


    public function __construct(
        UserRepository $userRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->userRepository = $userRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = $this->userRepository->findById(\Auth::user()->id);
        $breadcrumbs = $this->getBreadcrumb();
        return view('panel.profile.show', compact('user', 'breadcrumbs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('panel.user.form', [
            'user' => $this->getUser()->findById($id),
            'method' => 'PUT',
            'routePrefix' => "user-{$this->getRole()}",
            'route' => "user-{$this->getRole()}.update",
            'parameters' => [$id],
            'breadcrumbs' => $this->getBreadcrumb('Editar')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->formRequest($request->all());
        $this->validate(
            $request, $this->getUser()->validateRules(), $this->getUser()->validateMessages()
        );
        $this->getUser()->findOrFail($id)->update($data);

        return redirect()->route("user-{$this->getRole()}.edit", $id)->with([
            'success' => true,
            'message' => 'Usu&aacute;rio atualizado com sucesso!',
            'route' => "user-{$this->getRole()}.show",
            'id' => $id
        ]);
    }

    /**
     * @param string $location
     * @return array
     */
    protected function getBreadcrumb($location = null)
    {
        if ($location) {
            return $this->breadcrumbService
                ->add('Meu Perfil', route('profile.index'))
                ->add($location, null, true)
                ->get();
        }

        return $this->breadcrumbService->add('Meu Perfil', null, true)->get();
    }

}

