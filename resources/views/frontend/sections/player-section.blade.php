<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div id="app-cover">
    <div id="player">
        <div id="player-track">
            <div id="album-name"></div>
            <div id="track-name"></div>
            <div id="track-time">
                <div id="current-time"></div>
                <div id="track-length"></div>
            </div>
            <div id="s-area">
                <div id="ins-time"></div>
                <div id="s-hover"></div>
                <div id="seek-bar"></div>
            </div>
        </div>
        <div id="player-content">
            <div id="album-art">
                <img src="{{ get_image(@$liveSchedule->image, 'schedule') }}" class="active" id="_1">
                <div id="buffer-box">{{ __("Buffering") }}....</div>
            </div>
            <div id="player-controls">
                <div class="control">
                    <div class="button" id="play-pause-button">
                        <i class="las la-play"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
