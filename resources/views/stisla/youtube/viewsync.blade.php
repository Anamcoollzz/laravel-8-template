<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
  <title>ViewSync - Multiple YouTube Viewer</title>

  <meta charset="UTF-8" />

  <meta name="description" content="The best way to watch multiple YouTube videos at once. Built-in support for content creators." />
  <meta name="keywords" content="viewsync, mindcrack, uhc, ultrahardcore, minecraft, youtube viewer, multiple youtube viewer, youtube mashup, multiple video viewer, video mashup" />

  <meta name="robots" content="index, follow" />
  <meta property="og:image" content="http://viewsync.net/assets/img/ViewSync-250.png" />

  <!-- Prevent caching of page contents -->
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Cache-control" content="max-age=0" />
  <meta http-equiv="Cache-Control" content="post-check=0, pre-check=0" />
  <meta http-equiv="Expires" content="0" />
  <meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT" />

  <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="apple-mobile-web-app-capable" content="yes" />

  <link rel="stylesheet" type="text/css" href="https://viewsync.net/assets/css/normalize.css" />
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="https://viewsync.net/assets/css/index.css?v=f539ca9db6042d7c67f8ba6ac89746e3" />

  <!-- Gradient support for IE9 -->
  <!--[if gte IE 9]>
 <style type="text/css">
  .gradient {
  filter: none;
  }
 </style>
 <![endif]-->

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
 <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
 <![endif]-->

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/png" href="assets/img/favicon.png" />

  <!-- Google Webfonts -->
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lato:100,300,400,700" />
</head>

<body ontouchstart>
  <div id="header">
    <h1>ViewSync</h1>
    <h2>by <a href="http://redbanhammer.com">RedBanHammer</a></h2>
  </div>

  <div class="section" id="step1">
    <h3><span>Step 1:</span> Add Video</h3>
    <div class="content">
      <div id="addVideo" class="addVideo button videoWrapper">
        <div class="container buttonState">
          <i class="fa fa-plus"></i>
        </div>
        <div class="container inputState">
          <input type="text" placeholder="Paste YouTube or VS URL" class="startAtInput" />
        </div>
      </div>
    </div>
  </div>

  <div class="section" id="step2">
    <div class="button" id="testAudio" testing-message="<span>Step 2:</span> Testing . . . ." default-message="<span>Step 2:</span> Test Audio">
      <span>Step 2:</span> Test Audio
    </div>
  </div>

  <div class="section" id="step3">
    <div class="wrapper">
      <div class="button" id="generateLink"><span>Step 3:</span> ViewSync!</div>
      <div id="separateAudio" class="toggle">
        <div class="toggleDisplay">
          <i class="fa fa-times"></i>
          <i class="fa fa-check"></i>
        </div>
        <div class="label">Videos share audio</div>
      </div>
      <div class="toggle--description">Enable to mute all videos except one</div>

      <div id="autoplayVideos" class="toggle active">
        <div class="toggleDisplay">
          <i class="fa fa-times"></i>
          <i class="fa fa-check"></i>
        </div>
        <div class="label">Auto-buffer (breaks ads)</div>
      </div>
      <div class="toggle--description">Enable to buffer videos immediately</div>
    </div>
    <div class="wrapper generatedLinkWrapper">
      <input type="text" value="" class="generatedLink" />
    </div>
  </div>

  <div id="footer">
    <div class="wrapper">
      <h3>What is ViewSync?</h3>
      <p>
        <b>ViewSync is a multiple YouTube viewer.</b> Originally designed for watching <a href="http://mindcrack.altervista.org/wiki/MindCrack_Ultra_Hardcore" target="_blank">Mindcrack
          UHC</a> episodes, ViewSync can also be used to watch any number of YouTube videos at once. <a href="/watch?v=qj8s89PE180&t=191s&v=wLCFsXMOBy0&t=974s&v=iiLqi4Op0hs&t=114s">Here</a> is an
        example
        ViewSync from UHC season 10.
      </p>

      <h3>How do I ViewSync?</h3>
      <p>
        <b>Making ViewSync links is easy.</b> If the videos share the same voice audio, simply stop each video
        at a particular audio cue. Cues can be anything from the first word of a sentence to a sneeze. You can
        use the Test Audio button to check your syncing. Once satisfied, press the ViewSync! button to generate
        the link.
      </p>

      <h3>Why ViewSync?</h3>
      <p>
        <b>ViewSync puts content creators first.</b> While typical YouTube mashup sites are limited to showing
        <a href="https://support.google.com/youtube/answer/187095?hl=en&ref_topic=30072" target="_blank">banner
          ads</a>, ViewSync uses a proprietary method enabling <a href="https://support.google.com/youtube/answer/187096?hl=en" target="_blank">in-stream ads</a>.
        These in-stream ads pay content creators <i>much more</i> than banner ads; by using ViewSync, you are
        directly supporting content creators.
        <br><br>
        <b>ViewSync syncs to fractions of a second.</b> Create super-synced audio mashups using ViewSync's
        advanced playback logic. Audio syncing is accurate to within a tenth of a second. Only ViewSync can sync
        this audio in <a href="/watch?v=pM3CptVZDYU&t=0.0&v=ZIvZq-zgXkQ&t=6.67">Battlestar Galactica</a>.
      </p>

      <h3>Who made ViewSync?</h3>
      <p>
        <b>RedBanHammer.</b> I'm not affiliated with YouTube or Mindcrack and work on ViewSync in my spare time.
        If you like what you see here, feel free to check out my <a href="http://redbanhammer.com" target="_blank">other projects</a>! You can also <a
          href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=N44PSL2TUHJ7J" target="_blank">buy me a coffee</a> for late night coding sessions.
      </p>
    </div>
  </div>

  <!-- HTML templates used to structure the page -->
  <div class="template" id="videoElementTemplate">
    <div class="videoWrapper" videoId="{playerId}" id="videoWrapper-{playerUid}" uid="{playerUid}">
      <div class="container videoPlayer" id="videoPlayer-{playerUid}" uid="{playerUid}"></div>
      <div class="container button removeVideo">
        <i class="fa fa-times"></i>
      </div>
      <div class="container startTime">
        <div class="label">Start at</div>
        <input type="text" value="{startTime}" class="startAtInput" placeholder="0" readonly />
      </div>
      <div class="container errorMessage">
        <div class="label"><i class="fa fa-times"></i> Invalid video</div>
      </div>
      <div class="container testingMessage">
        <div class="label"><i class="fa fa-play"></i> Playing audio</div>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script type="text/javascript" src="https://viewsync.net/assets/js/jquery-1.8.1.min.js"></script>
  <script type="text/javascript" src="//www.youtube.com/iframe_api"></script>
  <script type="text/javascript" src="{{ asset('plugins/viewsync/index.js') }}"></script>

  <!-- Trackers -->
  <script type="text/javascript">
    var sc_project = 8943410;
    var sc_invisible = 1;
    var sc_security = "fa8cccc7";
    var scJsHost = (("https:" == document.location.protocol) ? "https://secure." : "http://www.");
    document.write("<sc" + "ript type='text/javascript' src='" + scJsHost + "statcounter.com/counter/counter.js'></" + "script>");
  </script>

  <script>
    var videoId = '{{ $videoId }}';

    var seconds = [];
    for (let a = 5; a < 100; a += 3) {
      seconds.push(a);
    }
    console.log('seconds', seconds)

    function getRandom(items) {
      var item = items[Math.floor(Math.random() * items.length)];
      return item;
    }

    function loop() {
      var inputLength = $('.startAtInput').length
      $('.startAtInput').eq(inputLength - 2).val(videoId);
      $('.startAtInput').eq(inputLength - 2).blur();

      let second = getRandom(seconds) * 1000

      console.log('add again in', second)
      setTimeout(() => {
        loop();
      }, second);
    }

    $(function() {
      setTimeout(() => {
        loop();
      }, 2000);
    });
  </script>
</body>

</html>
