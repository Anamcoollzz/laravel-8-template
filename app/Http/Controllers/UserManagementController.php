<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ImportExcelRequest;
use App\Http\Requests\UserRequest;
use App\Imports\UserImport;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserManagementController extends StislaController
{
    /**
     * user repository
     *
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * constructor method
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository;
        $this->icon           = 'fa fa-users';

        $this->defaultMiddleware('Pengguna');
    }

    /**
     * get index data
     *
     * @return array
     */
    private function getIndexData()
    {
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        $defaultData = $this->getDefaultDataIndex(__('Pengguna'), 'Pengguna', 'user-management.users');
        return array_merge($defaultData, [
            'data'      => $this->userRepository->getUsers(),
            'roleCount' => count($roleOptions),
        ]);
    }

    /**
     * get store data
     *
     * @param UserRequest $request
     * @return array
     */
    private function getStoreData(UserRequest $request): array
    {
        $data = $request->only([
            'name',
            'email',
            'phone_number',
            'birth_date',
            'address',
        ]);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
        return $data;
    }

    /**
     * get export data
     *
     * @return array
     */
    private function getExportData(): array
    {
        $times = date('Y-m-d_H-i-s');
        $data = [
            'isExport'   => true,
            'pdf_name'   => $times . '_users.pdf',
            'excel_name' => $times . '_users.xlsx',
            'csv_name'   => $times . '_users.csv',
            'json_name'  => $times . '_users.json',
        ];
        return array_merge($this->getIndexData(), $data);
    }

    /**
     * showing user management page
     *
     * @return Response
     */
    public function index()
    {
        $data = $this->getIndexData();
        return view('stisla.user-management.users.index', $data);
    }

    /**
     * showing add new user page
     *
     * @return Response
     */
    public function create()
    {
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        return view('stisla.user-management.users.form', [
            'roleOptions' => $roleOptions,
            'isDetail'    => false,
            'action'      => __("Tambah"),
        ]);
    }

    /**
     * save new user to db
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        $user = $this->userRepository->create($this->getStoreData($request));
        $this->userRepository->syncRoles($user, $request->role);
        logCreate('Pengguna', $user);
        $successMessage = successMessageCreate('Pengguna');
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing edit user page
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        if ($user->roles->count() > 1)
            $user->role = $user->roles->pluck('id')->toArray();
        else
            $user->role = $user->roles->first()->id ?? null;
        return view('stisla.user-management.users.form', [
            'roleOptions' => $roleOptions,
            'd'           => $user,
            'isDetail'    => false,
            'action'      => __("Ubah"),
        ]);
    }

    /**
     * update user to db
     *
     * @param UserRequest $request
     * @param User $user
     * @return Response
     */
    public function update(UserRequest $request, User $user)
    {
        $data = $this->getStoreData($request);

        $userNew = $this->userRepository->update($data, $user->id);
        $this->userRepository->syncRoles($userNew, $request->role);
        logUpdate('Pengguna', $user, $userNew);
        $successMessage = successMessageUpdate('Pengguna');
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * showing detail user page
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $roleOptions = $this->userRepository->getRoles()->pluck('name', 'id')->toArray();
        if ($user->roles->count() > 1)
            $user->role = $user->roles->pluck('id')->toArray();
        else
            $user->role = $user->roles->first()->id ?? null;
        return view('stisla.user-management.users.form', [
            'roleOptions' => $roleOptions,
            'd'           => $user,
            'isDetail'    => true,
            'action'      => __("Detail"),
        ]);
    }

    /**
     * delete user from db
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $this->userRepository->delete($user->id);
        logDelete('Pengguna', $user);
        $successMessage = successMessageDelete('Pengguna');
        return redirect()->back()->with('successMessage', $successMessage);
    }

    /**
     * force login with specific user
     *
     * @param User $user
     * @return Response
     */
    public function forceLogin(User $user)
    {
        $this->userRepository->login($user);
        return Helper::redirectSuccess(route('dashboard.index'), __('Berhasil masuk ke dalam sistem'));
    }

    /**
     * download import example
     *
     * @return BinaryFileResponse
     */
    public function importExcelExample(): BinaryFileResponse
    {
        $filepath = public_path('excel_examples/users.xlsx');
        return response()->download($filepath);
    }

    /**
     * import excel file to db
     *
     * @param ImportExcelRequest $request
     * @return RedirectResponse
     */
    public function importExcel(ImportExcelRequest $request): RedirectResponse
    {
        $this->fileService->importExcel(new UserImport, $request->file('import_file'));
        $successMessage = successMessageImportExcel("Pengguna");
        return back()->with('successMessage', $successMessage);
    }

    /**
     * download export data as json
     *
     * @return BinaryFileResponse
     */
    public function json(): BinaryFileResponse
    {
        $data  = $this->getExportData();
        return $this->fileService->downloadJson($data['data'], $data['json_name']);
    }

    /**
     * download export data as xlsx
     *
     * @return Response
     */
    public function excel(): BinaryFileResponse
    {
        $data  = $this->getExportData();
        return $this->fileService->downloadExcelGeneral('stisla.user-management.users.table', $data, $data['excel_name']);
    }

    /**
     * download export data as csv
     *
     * @return Response
     */
    public function csv(): BinaryFileResponse
    {
        $data  = $this->getExportData();
        return $this->fileService->downloadCsvGeneral('stisla.user-management.users.table', $data, $data['csv_name']);
    }

    /**
     * download export data as pdf
     *
     * @return Response
     */
    public function pdf(): Response
    {
        $data  = $this->getExportData();
        return $this->fileService->downloadPdfLetter('stisla.includes.others.export-pdf', $data, $data['pdf_name']);
    }
}
