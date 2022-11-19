<?php

namespace App\Http\Controllers\Api;

use Alaouy\Youtube\Facades\Youtube;
use App\Http\Controllers\Controller;
use App\Services\YoutubeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * get list video from youtube channel
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getListVideoFromChannel(Request $request)
    {
        $videoList = $this->youtubeService->getListVideoFromChannelId($request->query('channelId'));
        return response()->json($videoList);
    }
}
