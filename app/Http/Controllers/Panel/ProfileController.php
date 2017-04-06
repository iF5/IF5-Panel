<?php

namespace App\Http\Controllers\Panel;

use Illuminate\Http\Request;
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


    private $extensions = [
        'jpeg',
        'jpg',
        'png',
        'gif'
    ];

    public function __construct(
        UserRepository $userRepository,
        BreadcrumbService $breadcrumbService
    )
    {
        $this->userRepository = $userRepository;
        $this->breadcrumbService = $breadcrumbService;
    }

    /**
     * @return mixed
     */
    protected function getId()
    {
        return \Auth::user()->id;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('panel.user.show', [
            'user' => $this->userRepository->findById($this->getId()),
            'routePrefix' => 'profile',
            'breadcrumbs' => $this->getBreadcrumb()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $id = $this->getId();
        return view('panel.user.form', [
            'user' => $this->userRepository->findById($id),
            'method' => 'PUT',
            'routePrefix' => 'profile',
            'route' => 'profile.update',
            'parameters' => [$id],
            'breadcrumbs' => $this->getBreadcrumb('Editar')
        ]);
    }

    /**
     * @param array $data
     * @return array
     */
    protected function formRequest($data)
    {
        $data['password'] = bcrypt($data['password']);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $this->getId();
        $data = $this->formRequest($request->all());
        $this->validate(
            $request, $this->userRepository->validateRules($id), $this->userRepository->validateMessages()
        );

        $this->userRepository->findOrFail($id)->update($data);

        return redirect()->route('profile.edit')->with([
            'success' => true,
            'message' => 'Meu perfil foi atualizado com sucesso!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function image()
    {
        return view('panel.user.form-image', [
            'id' => $this->getId(),
            'breadcrumbs' => $this->getBreadcrumb('Imagem')
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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        if (!in_array($extension, $this->extensions)) {
            return response()->json([
                'message' => 'Só são permitidos arquivos do tipo ' . implode(', ', $this->extensions) .'.'
            ]);
        }

        $dir = public_path() . '/images/profile/';
        $name = sprintf('%s.%s', sha1($this->getId()), $extension);
        $file->move($dir, $name);
        $this->userRepository->find($this->getId())->update(['image' => $name]);

        return response()->json([
            'message' => "O arquivo {$file->getClientOriginalName()} foi enviado com sucesso!"
        ]);

    }

}

