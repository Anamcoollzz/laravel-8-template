<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Repositories\SettingRepository;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class SettingController extends Controller
{

    /**
     * setting repository var
     *
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * fileservice
     *
     * @var FileService
     */
    private FileService $fileService;

    /**
     * construct function
     *
     * @return void
     */
    public function __construct()
    {
        $this->settingRepository = new SettingRepository;
        $this->fileService       = new FileService;
    }

    /**
     * showing setting page
     *
     * @return View
     */
    public function index()
    {
        if (config('app.template') === 'stisla') {
            $skins = $this->settingRepository->getStislaSkins();
            return view('settings.index-stisla', [
                'skins'                            => $skins,
                'activeSkin'                       => $this->settingRepository->stislaSkin(),
                'login_must_verified'              => $this->settingRepository->loginMustVerified(),
                'is_active_register_page'          => $this->settingRepository->isActiveRegisterPage(),
                'is_forgot_password_send_to_email' => $this->settingRepository->isForgotPasswordSendToEmail(),
            ]);
        } else {
            $skins = collect($this->settingRepository->getSkins())->map(function ($item) {
                $item2['name'] = $item;
                return $item2;
            })->pluck('name', 'name')->toArray();
            return view('settings.index', [
                'skins' => $skins,
            ]);
        }
    }

    /**
     * update setting data
     *
     * @param SettingRequest $request
     * @return Response
     */
    public function update(SettingRequest $request)
    {
        foreach ($request->all() as $key => $input) {
            if ($key === 'favicon') {
                $url = $this->fileService->uploadFavicon($request->file('favicon'));
                $this->settingRepository->updateByKey(['value' => $url], $key);
            } else
                $this->settingRepository->updateByKey(['value' => $input], $key);
        }
        return back()
            ->with(config('app.template') === 'stisla' ? 'successMessage' : 'success_msg', __('Application Setting') . ' ' . __('success updated'));
    }
}
