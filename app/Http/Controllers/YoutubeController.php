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

    /**
     * viewer per video page
     *
     * @return Response
     */
    public function viewerPerVideo()
    {
        return view('stisla.youtube.per-video', [
            'title' => 'Youtube Viewer Per Video',
            'videoId' => request()->query('videoId') ?? '3Cv0r3Ees0I',
        ]);
    }
}
