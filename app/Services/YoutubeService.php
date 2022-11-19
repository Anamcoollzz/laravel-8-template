<?php

namespace App\Services;

use Alaouy\Youtube\Facades\Youtube;

class YoutubeService
{

    /**
     * YoutubeService constructor.
     */
    public function __construct()
    {
    }

    /**
     * get list video from youtube channel
     *
     * @param string $channelId
     * @return array
     */
    public function getListVideoFromChannelId(string $channelId = null)
    {
        $videoList  = Youtube::listChannelVideos($channelId ?? config('youtube.channel_id'), 100);
        $links      = [];
        $shortLinks = [];
        $id         = [];
        $titles     = [];

        foreach ($videoList as $video) {
            $links[] = 'https://www.youtube.com/watch?v=' . $video->id->videoId;
            $id[] = $video->id->videoId;
            $shortLinks[] = 'https://youtu.be/' . $video->id->videoId;
            $titles[] = $video->snippet->title;
        }

        return [
            'id'         => $id,
            'links'      => $links,
            'shortLinks' => $shortLinks,
            'titles'     => $titles
        ];
    }
}
