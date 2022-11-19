<?php

/*
|--------------------------------------------------------------------------
| Laravel PHP Facade/Wrapper for the Youtube Data API v3
|--------------------------------------------------------------------------
|
| Here is where you can set your key for Youtube API. In case you do not
| have it, it can be acquired from: https://console.developers.google.com
*/

return [
    'key'        => env('YOUTUBE_API_KEY', 'YOUR_API_KEY'),
    'channel_id' => env('YOUTUBE_CHANNEL_ID', 'UCwF-njZKFE30pZwWFtp84fA'),
];
