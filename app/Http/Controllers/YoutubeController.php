<?php

namespace App\Http\Controllers;

use App\Services\YoutubeService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class YoutubeController extends Controller
{
    /**
     * @var YoutubeService
     *
     */
    private YoutubeService $youtubeService;

    /**
     * YoutubeController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->youtubeService = new YoutubeService;
    }

    /**
     * viewer page
     *
     * @return Response
     */
    public function viewer()
    {
        return view('stisla.youtube.index', [
            'title' => 'Youtube Viewer',
            'videos' => $this->youtubeService->getListVideoFromChannelId(),
        ]);
    }
}
