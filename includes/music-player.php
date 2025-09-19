<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head><!-- Music Player Footer -->
<style>
    .audio-player-container {
        position: fixed;
        bottom: 0;
        left: 200px;
        right: 0;
        background: rgba(18, 18, 18, 0.95);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 16px 24px;
        height: 90px;
        backdrop-filter: blur(10px);
    }

    .audio-player {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 24px;
        height: 100%;
    }

    .song-info {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-shrink: 0;
        min-width: 180px;
    }

    .album-cover {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        object-fit: cover;
    }

    .track-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .track-title {
        font-weight: 500;
        font-size: 14px;
        color: #fff;
    }

    .track-artist {
        font-size: 12px;
        color: #b3b3b3;
    }

    .playback-controls {
        flex-grow: 1;
        max-width: 722px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
    }

    .controls {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 16px;
        margin-bottom: 8px;
    }

    .control-btn {
        background: none;
        border: none;
        color: #b3b3b3;
        font-size: 16px;
        padding: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .control-btn:hover {
        color: #fff;
        transform: scale(1.1);
    }

    .play-pause {
        background: #fff;
        color: #000;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .play-pause:hover {
        transform: scale(1.1);
        background: #1ed760;
    }

    .progress-container {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .progress-bar {
        flex-grow: 1;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
        position: relative;
        cursor: pointer;
    }

    .progress {
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        background: #1ed760;
        border-radius: 2px;
        width: 100%;
    }

    .time {
        font-size: 12px;
        color: #b3b3b3;
        min-width: 40px;
        text-align: center;
    }

    .volume-control {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 140px;
    }

    .volume-slider {
        width: 100px;
        height: 4px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
        position: relative;
        cursor: pointer;
    }

    .volume-slider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 70%;
        background: #b3b3b3;
        border-radius: 2px;
    }

    .volume-slider:hover::before {
        background: #1ed760;
    }
    .song-info .fa-heart {
    font-size: 18px;
    color: #b3b3b3;
    cursor: pointer;
    transition: color 0.2s ease, transform 0.2s ease;
}

.song-info .fa-heart:hover {
    color: #ff4d4d;
    transform: scale(1.2);
}

</style>

<div class="audio-player-container">
    <div class="audio-player">
        <!-- Song Info -->
        <div class="song-info">
            <img src="https://via.placeholder.com/56" alt="Album Cover" class="album-cover">
            <div class="track-info">
                <span class="track-title">SoundHelix Song 1</span>
                <span class="track-artist">SoundHelix</span>
            </div>
            <i class="fas fa-heart"></i>
        </div>

        <!-- Playback Controls -->
        <div class="playback-controls">
            <div class="progress-container">
                <div class="progress-bar">
                    <span class="time current-time">0:00</span>
                    <input type="range" class="progress" value="0" max="100">
                    <span class="time duration">3:00</span>
                </div>
            </div>
            
            <div class="controls">
                <button class="control-btn shuffle"><i class="fas fa-random"></i></button>
                <button class="control-btn prev"><i class="fas fa-step-backward"></i></button>
                <button class="control-btn play-pause"><i class="fas fa-play"></i></button>
                <button class="control-btn next"><i class="fas fa-step-forward"></i></button>
                <button class="control-btn repeat"><i class="fas fa-redo"></i></button>
            </div>
        </div>

        <!-- Volume Control -->
        <div class="volume-control">
            <i class="fas fa-volume-up"></i>
            <input type="range" class="volume-slider" value="100" max="100">
        </div>
    </div>
</div>
<br>