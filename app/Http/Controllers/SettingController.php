<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingRequest;
use App\Repositories\SettingRepository;
use App\Services\FileService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
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

        $this->middleware('can:Pengaturan');
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
            return view('stisla.settings.index', [
                'skins' => $skins,
            ]);
        } else {
            $skins = collect($this->settingRepository->getSkins())->map(function ($item) {
                $item2['name'] = $item;
                return $item2;
            })->pluck('name', 'name')->toArray();
            return view('sbadmin.settings.index', [
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
        $before = $this->settingRepository->all();
        foreach ($request->all() as $key => $input) {
            $value = $input;
            if ($key === 'favicon') {
                $value = $this->fileService->uploadFavicon($request->file('favicon'));
            } else if ($key === 'logo') {
                $value = $this->fileService->uploadLogo($request->file('logo'));
            } else if ($key === 'stisla_bg_login') {
                $value = $this->fileService->uploadStislaBgLogin($request->file('stisla_bg_login'));
            } else if ($key === 'stisla_bg_home') {
                $value = $this->fileService->uploadStislaBgHome($request->file('stisla_bg_home'));
            }
            $this->settingRepository->updateByKey(['value' => $value], $key);
        }
        $settings = SettingRepository::settings();
        foreach ($settings as $key => $setting) {
            Session::forget('_' . $key);
        }
        Session::forget('_logo_url');
        Session::forget('_logo');
        $after = $this->settingRepository->all();
        logUpdate('Pengaturan', $before, $after);
        return back()->with(config('app.template') === 'stisla' ? 'successMessage' : 'success_msg', __('Application Setting') . ' ' . __('success updated'));
    }
}
