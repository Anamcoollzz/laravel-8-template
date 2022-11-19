var main = {
  isTestingAudio: false,

  initialize: function () {
    $.ajaxSetup({
      timeout: main.CONST.ajaxTimeout,
    });

    main.ui.initialize();
  },

  generateLink: function (separateAudio, autoplayVideos) {
    console.log('generateLink');
    var videoEls = $('#step1 .content .videoWrapper').not('#addVideo, .error');
    var link = 'http://viewsync.net/watch?';

    if (videoEls.length == 0) return;

    videoEls.each(function (i) {
      var t = $(this);
      var uid = t.attr('uid');
      var vid = t.attr('videoId');
      var input = t.find('input.startAtInput');
      var startTime = parseFloat(input.val());

      link += (i != 0 ? '&' : '') + 'v=' + vid + '&t=' + startTime;
    });

    if (separateAudio) link += '&mode=solo';
    if (!autoplayVideos) link += '&autoplay=false';

    //console.log("/srv/api.php?url=" + encodeURIComponent(link));

    var input = $('#step3 .generatedLinkWrapper').addClass('visible').find('input.generatedLink');
    var postSetCleanup = function () {
      setTimeout(function () {
        input.click();
      }, 50);
    };

    // if (shortLink) {
    // 	$.get("/srv/api.php?url=" + encodeURIComponent(link), function(data) {
    // 		if (data == "0" || typeof data === "undefined" || !data) { // fallback to non shortlink
    // 			input.val(link).attr("default-val", link);
    // 			postSetCleanup();
    // 		} else {
    // 			input.val(data).attr("default-val", data);
    // 			postSetCleanup();
    // 		}
    // 	}).error(function(jqXHR, textStatus, errorThrown) {
    // 		console.log("Error generating short link: ", jqXHR, textStatus, errorThrown);
    // 		input.val(link).attr("default-val", link);
    // 		postSetCleanup();
    // 	});
    // } else {
    input.val(link).attr('default-val', link);
    postSetCleanup();
    // }
  },

  ui: {
    initialize: function () {
      main.ui.attachHandlers();
    },

    addVideoElement: function () {
      $('#step1 content').append(main.util.template($('#addVideoTemplate').html(), {}));
    },

    videoPlayerUID: -1, // Increments each video added
    videoPlayers: {},

    attachHandlers: function () {
      $('#separateAudio, #autoplayVideos').click(function () {
        var t = $(this);
        if (t.hasClass('active')) {
          t.removeClass('active');
        } else {
          t.addClass('active');
        }
      });

      // Adding, removing, editing video states
      $('#addVideo').click(function () {
        var t = $(this);
        t.addClass('inputState');

        t.find('.inputState input').focus();
      });
      $('#addVideo .inputState input')
        .blur(function () {
          var t = $(this);
          var v = t.val();
          console.log('v', v);

          var id = [];
          var time = [];
          var params;

          t.closest('#addVideo').removeClass('inputState');

          if (v.replace(/\s+/g, '') != '') {
            // Check whether the user pasted an actual url or just the ID
            if (v.indexOf('youtube.com') > -1) {
              if (v.indexOf('/watch?v=') > -1) {
                params = v.split('/watch?v=')[1];
                id.push(params.split('&')[0]);
                if (params.indexOf('&t=') > -1) {
                  time.push(main.util.timeStringToSeconds(params.split('&t=')[1].split('&')[0]));
                } else if (params.indexOf('#t=') > -1) {
                  time.push(main.util.timeStringToSeconds(params.split('#t=')[1].split('&')[0]));
                } else {
                  time.push(0);
                }
              }
            } else if (v.indexOf('youtu.be') > -1) {
              if (v.indexOf('https://') == 0) {
                params = v.split('https://')[1].split('/')[1];
              } else {
                params = v.split('http://')[1].split('/')[1];
              }
              id.push(params.split('?')[0]);
              if (params.indexOf('?t=') > -1) {
                time.push(main.util.timeStringToSeconds(params.split('?t=')[1].split('&')[0]));
              } else if (params.indexOf('#t=') > -1) {
                time.push(main.util.timeStringToSeconds(params.split('#t=')[1].split('&')[0]));
              } else {
                time.push(0);
              }
            } else if (v.indexOf('viewsync.net/watch?') > -1 || v.indexOf('viewsync.net/stream?') > -1 || v.indexOf('minemap.net/Mindcrack/uhc/?') > -1) {
              if (v.indexOf('viewsync.net/watch?') > -1) v = v.split('viewsync.net/watch?')[1];
              if (v.indexOf('viewsync.net/stream?') > -1) v = v.split('viewsync.net/stream?')[1];
              if (v.indexOf('minemap.net/Mindcrack/uhc/?') > -1) v = v.split('minemap.net/Mindcrack/uhc/?')[1];
              v = v.split('&');
              var params = v;

              console.log('params', params);

              for (i = 0; i < params.length; i++) {
                var s = params[i].split('=');
                var loadingFromSV = false;
                switch (s[0]) {
                  case 'v':
                    id.push(s[1]);
                    if (i + 1 < params.length && params[i + 1].split('=')[0] == 't') {
                      var hours = 0;
                      var minutes = 0;
                      var seconds = 0;
                      var str = params[i + 1].split('=')[1];

                      if (str.indexOf('h') > -1) {
                        hours = parseFloat(str.split('h')[0]);
                        str = str.split('h')[1];
                      }

                      if (str.indexOf('m') > -1) {
                        minutes = parseFloat(str.split('m')[0]);
                        str = str.split('m')[1];
                      }

                      seconds = parseFloat(str);

                      time.push(hours * 60 * 60 + minutes * 60 + seconds);
                    } else {
                      time.push(0);
                    }
                    break;
                  case 'mode':
                    if (s[1] == 'solo') {
                      $('#separateAudio').removeClass('active');
                    } else {
                      $('#separateAudio').addClass('active');
                    }
                    break;
                  case 'm':
                    if (s[1] == 'solo') {
                      $('#separateAudio').removeClass('active');
                    } else {
                      $('#separateAudio').addClass('active');
                    }
                    break;
                }
              }
            } else {
              if (v.indexOf('&t=') > -1) {
                time.push(main.util.timeStringToSeconds(v.split('&t=')[1].split('&')[0]));
                id.push(v.split('&t=')[0]);
              } else if (v.indexOf('#t=') > -1) {
                time.push(main.util.timeStringToSeconds(v.split('#t=')[1].split('&')[0]));
                id.push(v.split('#t=')[0]);
              } else {
                time.push(0);
                id.push(v);
              }
            }
          }

          // console.log(id, time);

          // Sanitize
          for (i in id) id[i] = encodeURIComponent(id[i]);

          t.val('');

          console.log('id', id);

          if (id.length > 0) {
            for (i in id) {
              var _id = id[i];
              var _time = time[i];
              main.ui.videoPlayerUID++;

              //console.log(_time);

              var newVideo = main.util.template($('#videoElementTemplate').html(), {
                playerId: _id,
                playerUid: main.ui.videoPlayerUID,
                startTime: _time,
              });

              $('#addVideo').before(newVideo);

              main.ui.createYTPlayer(
                'videoPlayer-' + main.ui.videoPlayerUID,
                main.CONST.playerOpt.height,
                main.CONST.playerOpt.width,
                _id,
                {
                  start: parseInt(Math.floor(_time)),
                  autohide: '0',
                  iv_load_policy: '3',
                  color: 'white',
                  fs: '0',
                  theme: 'light',
                  showinfo: '0',
                  rel: '0',
                  autoplay: '1',
                  wmode: 'transparent',
                },
                main.ui.videoPlayerUID
              );

              // Attach remove events
              $('#videoWrapper-' + main.ui.videoPlayerUID + ' .removeVideo').click(function () {
                var t = $(this);
                t.closest('.videoWrapper').remove();
              });

              // Attach auto selection handlers
              $('#videoWrapper-' + main.ui.videoPlayerUID + ' input.startAtInput')
                .focus(function () {
                  var t = $(this);
                  setTimeout(function () {
                    t.get(0).select();
                  }, 0);
                })
                .change(function () {
                  var t = $(this);
                  var v = t.val();

                  // Sanitize the value and make it into seconds
                  if (v.indexOf(':') > -1) {
                    var _time = v.split(':');
                    var time = 0;
                    for (var i = 0; i < _time.length; i++) {
                      time += parseFloat(_time[i]) * Math.pow(60, _time.length - i - 1);
                    }
                    time = parseFloat(time);
                    t.val(time.toString() == 'NaN' ? 0 : time);
                  } else if (v.indexOf('h') > -1 || v.indexOf('m') > -1 || v.indexOf('s') > -1) {
                    time = parseFloat(main.util.timeStringToSeconds(v));
                    t.val(time.toString() == 'NaN' ? 0 : time);
                  } else {
                    v = v.replace(/[^0-9\.]/g, '');
                    time = parseFloat(v);
                    t.val(time.toString() == 'NaN' ? 0 : time);
                  }

                  // Get the uid
                  var uid = t.closest('.videoWrapper').attr('uid');

                  var player = main.ui.videoPlayers[uid];

                  player.mute();

                  main.ui.seekPlayerTo(player, parseFloat(t.val()));

                  setTimeout(function () {
                    player.unMute();
                    player.pauseVideo();
                  }, 1000);

                  t.blur();
                })
                .keypress(function (e) {
                  if (e.which == 13) $(this).blur();
                });
            }
          }
        })
        .focus(function () {
          /*var t = $(this);

				setTimeout(function() {
					if (t.val() == "") t.get(0).select();
				}, 0);*/
        })
        .on('paste', function () {
          var t = $(this);
          setTimeout(function () {
            // Paste event fires before val changes
            t.blur();
          }, 0);
        })
        .keypress(function (e) {
          if (e.which == 13) $(this).blur();
        });

      // For testing the audio based on the current view model
      $('#testAudio').click(function () {
        if (main.isTestingAudio) return;
        main.isTestingAudio = true;

        var t = $(this);

        var videoEls = $('#step1 .content .videoWrapper').not('#addVideo, .error');

        // console.log(videoEls.length);
        if (videoEls.length == 0) return;

        t.html(t.attr('testing-message'));
        videoEls.each(function (i) {
          try {
            var t = $(this);
            var uid = t.attr('uid');
            var input = t.find('input.startAtInput');
            var startTime = parseFloat(input.val());
            var player = main.ui.videoPlayers[uid];

            input.attr('readonly', '');

            player.pauseVideo();
            player.mute();

            main.ui.seekPlayerTo(player, startTime);

            setTimeout(function () {
              player.playVideo();
              setTimeout(function () {
                player.unMute();
                t.addClass('testing');

                setTimeout(function () {
                  player.mute();
                  t.removeClass('testing');

                  setTimeout(function () {
                    player.unMute();
                    t.addClass('testing');

                    setTimeout(function () {
                      player.pauseVideo();
                      t.removeClass('testing');

                      main.ui.seekPlayerTo(player, startTime);

                      setTimeout(function () {
                        player.unMute();
                        player.pauseVideo();
                        input.removeAttr('readonly');

                        var buttonEl = $('#testAudio');
                        buttonEl.html(buttonEl.attr('default-message'));

                        if (i + 1 == videoEls.length) main.isTestingAudio = false;
                      }, 1000);
                    }, (videoEls.length - i) * main.CONST.audioTestTime);
                  }, (videoEls.length - (i + 1)) * main.CONST.audioTestTime + i * main.CONST.audioTestTime);
                }, main.CONST.audioTestTime);
              }, main.CONST.audioTestTime * i);
            }, 1500);
          } catch (e) {
            main.isTestingAudio = false;
            return false;
          }
        });
      });

      $('#generateLink').click(function () {
        main.generateLink(!$('#separateAudio').hasClass('active'), $('#autoplayVideos').hasClass('active'));
      });

      var autoFocus = function () {
        var t = $(this);
        setTimeout(function () {
          t.val(t.attr('default-val'));
          t.get(0).select();
        }, 0);
      };
      $('#step3 input.generatedLink').focus(autoFocus).click(autoFocus).on('keydown', autoFocus).change(autoFocus);
    },

    createYTPlayer: function (playerDiv, playerHeight, playerWidth, playerVideoId, playerVars, uid) {
      console.log('uid', uid);
      console.log('playerVideoId', playerVideoId);
      var newPlayer = new YT.Player(playerDiv, {
        height: playerHeight,
        width: playerWidth,
        videoId: playerVideoId,
        playerVars: playerVars,
        events: {
          onStateChange: function (s) {
            //console.log(s);
            /*var autoPause = function() {
							var player = main.ui.videoPlayers[uid];
							if (s != 2 && !main.isTestingAudio) {
								player.pauseVideo();
							} else {
								player.unMute();
							}
						};
						autoPause();
						setTimeout(function() {
							autoPause();
						}, 500);*/
          },
          onReady: function (e) {
            //console.log(e);
            var player = e.target;
            player.mute();
            var startTime = parseFloat(
              $('#' + playerDiv)
                .closest('.videoWrapper')
                .find('input.startAtInput')
                .val()
            );
            setTimeout(function () {
              // Allows thumbnails to be shown
              player.unMute();
              player.pauseVideo();
              if (player.getPlayerState() == 5) {
                // Video error
                $('#' + playerDiv)
                  .closest('.videoWrapper')
                  .addClass('error');
              }

              main.ui.seekPlayerTo(player, startTime);
            }, 500);

            main.ui.videoPlayers[uid].gotReadyEvent = true;

            setTimeout(function () {
              $('#' + playerDiv)
                .closest('.videoWrapper')
                .find('input.startAtInput')
                .removeAttr('readonly');
            }, 500);

            main.ui.videoPlayers[uid].pollingInterval = setInterval(function () {
              var player = main.ui.videoPlayers[uid];

              if (typeof player === 'undefined' || !player || main.isTestingAudio) return;
              //if (!main.isTestingAudio) player.pauseVideo();

              if (main.ui.videoPlayers[uid].lastPlayerTime != Math.round(player.getCurrentTime() * 100) / 100) {
                main.ui.videoPlayers[uid].lastPlayerTime = Math.round(player.getCurrentTime() * 100) / 100;
                $('#videoWrapper-' + uid + ' .startAtInput').val(main.ui.videoPlayers[uid].lastPlayerTime);
              }
            }, 50);
          },
          onError: function (e) {
            $('#' + playerDiv)
              .closest('.videoWrapper')
              .addClass('error');
          },
        },
      });

      main.ui.videoPlayers[uid] = newPlayer;

      main.ui.videoPlayers[uid].gotReadyEvent = false;
      main.ui.videoPlayers[uid].lastPlayerTime = playerVars.start;
    },

    seekPlayerTo: function (player, seconds) {
      seconds = parseFloat(seconds);

      player.seekTo(Math.floor(seconds));
      var initTime = player.getCurrentTime();

      console.log('Seeking... seconds: ', seconds);

      if (main.util.isFloat(seconds)) {
        player.playVideo();
        var seekInterval = setInterval(function () {
          if (player.getPlayerState() == 1 && player.getCurrentTime() != initTime) {
            clearInterval(seekInterval);
            setTimeout(function () {
              player.pauseVideo();
            }, (seconds - Math.floor(seconds)) * 1000);
          }
        }, 10);
      } else {
        player.pauseVideo();
      }
    },
  },

  CONST: {
    ajaxTimeout: 10 * 1000,
    playerOpt: {
      height: 140,
      width: 250,
    },
    audioTestTime: 2 * 1000, // time videos should play for audio testing
  },

  util: {
    /*
			Leaflet templating code
			@source: http://leafletjs.com/
		*/
    template: function (str, data) {
      return str.replace(/\{ *([\w_]+) *\}/g, function (str, key) {
        var value = data[key];
        if (!data.hasOwnProperty(key)) {
          throw new Error('No value provided for variable ' + str);
        }
        return value;
      });
    },

    timeStringToSeconds: function (str) {
      var h = 0;
      var m = 0;
      var s = 0;

      if (str.indexOf('h') > -1) {
        h = parseFloat(str.split('h')[0]);
        str = str.split('h')[1];
      }

      if (str.indexOf('m') > -1) {
        m = parseFloat(str.split('m')[0]);
        str = str.split('m')[1];
      }

      s = parseFloat(str.split('s')[0]);

      return h * 60 * 60 + m * 60 + s;
    },

    /*
			Check if a number is a float (1.0 = false, 1.1 = true)
			@source: http://stackoverflow.com/a/3885844
		*/
    isFloat: function (n) {
      return n === +n && n !== (n | 0);
    },
  },
};

main.initialize();
