<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Spotify music player</title>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
            integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <style>
            @import url(//db.onlinewebfonts.com/c/860c3ec7bbc5da3e97233ccecafe512e?family=Circular+Std+Book);

            * {
                box-sizing: border-box;
                font-family: "circular std book", sans-serif;
            }

            body {
                margin: 0;
                padding: 0;
                background-color: #222;
                font-size: 14px;
                color: #ddd;
            }

            .music-player {
                position: fixed;
                bottom: 0;
                left: 15%; /* Width of sidebar */
                right: 0;
                background: rgba(18, 18, 18, 0.95);
                padding: 16px 24px;
                height: 90px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                --primary-color: #f5f5f5;
                --secondary-color: #999;
                --green-color: #DC143C;
                --padding: 1em;
                z-index: 1000;
            }

            i {
                color: var(--secondary-color);
                cursor: pointer;
            }

            i:hover {
                color: var(--primary-color);
            }

            .song-bar {
                display: flex;
                align-items: center;
                width: 25%;
                min-width: 180px;
            }

            .song-infos {
                display: flex;
                align-items: center;
                gap: 1em;
            }

            .image-container {
                --size: 56px;
                flex-shrink: 0;
                width: var(--size);
                height: var(--size);
            }

            .image-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .song-description p {
                margin: 0.2em;
            }

            .title,
            .artist {
                display: -webkit-box;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 1;
                overflow: hidden;
            }

            .title:hover,
            .artist:hover {
                text-decoration: underline;
                cursor: pointer;
            }

            .artist {
                color: var(--secondary-color);
            }

            .icons {
                display: flex;
                gap: 1em;
                margin-left: 1em;
            }

            .progress-controller {
                width: 40%;
                max-width: 700px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 0.5em;
            }

            .control-buttons {
                display: flex;
                align-items: center;
                gap: 2em;
            }

            .play-pause {
                display: inline-block;
                padding: 1em;
                background-color: var(--primary-color);
                color: #111;
                border-radius: 50%;
                cursor: pointer;
            }

            .play-pause:hover {
                transform: scale(1.1);
                color: #111;
            }

            .progress-container {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 0.5em;
            }

            .progress-bar {
                height: 4px;
                border-radius: 10px;
                width: 100%;
                background-color: #ccc4;
                cursor: pointer;
                position: relative;
            }

            .progress {
                position: absolute;
                height: 100%;
                width: 30%;
                border-radius: 10px;
                background-color: var(--secondary-color);
                transition: width 0.1s ease;
            }

            .progress-bar:hover .progress {
                background-color: var(--green-color);
            }

            .progress-bar:hover .progress::after {
                content: "";
                position: absolute;
                --size: 1em;
                width: var(--size);
                height: var(--size);
                right: 0;
                border-radius: 50%;
                background-color: var(--primary-color);
                transform: translate(50%, calc(2px - 50%));
            }

            .other-features {
                display: flex;
                gap: 1em;
                align-items: center;
                width: 25%;
                min-width: 180px;
                justify-content: flex-end;
            }

            .volume-bar {
                display: flex;
                align-items: center;
                gap: 0.7em;
                width: 150px;
            }

            .volume-bar .progress-bar {
                width: 100%;
            }

            .volume-bar .progress-bar:hover .progress::after {
                --size: 0.8em;
            }

            @media screen and (max-width: 768px) {
                .music-player {
                    left: 0;
                    padding: 8px 16px;
                }

                .song-bar {
                    width: 30%;
                }

                .progress-controller {
                    width: 50%;
                }

                .other-features {
                    width: 20%;
                }

                .volume-bar {
                    width: 80px;
                }

                .control-buttons {
                    gap: 1em;
                }
            }

            @media screen and (max-width: 576px) {
                .song-infos .image-container {
                    --size: 40px;
                }

                .song-description {
                    display: none;
                }

                .icons,
                .volume-bar {
                    display: none;
                }

                .other-features {
                    gap: 0.5em;
                }

                .progress-controller {
                    width: 60%;
                }
            }
        </style>
    </head>
    <body>
    <!-- music-player.php -->
<audio id="audio-player" preload="auto">
    <source src="" type="audio/mpeg">
    Your browser does not support audio playback.
</audio>

<div class="music-player">
    <div class="song-bar">
        <div class="song-infos">
            <div class="image-container">
                <img id="player-cover" src="/api/placeholder/56/56" alt="Song cover" />
            </div>
            <div class="song-description">
                <p class="title" id="player-title">Select a song</p>
                <p class="artist" id="player-artist">Artist</p>
            </div>
        </div>
        <div class="icons">
            <!-- <i class="far fa-heart"></i> -->
        </div>
    </div>

    <div class="progress-controller">
        <div class="control-buttons">
            <i class="fas fa-step-backward"></i>
            <i class="play-pause fas fa-play"></i>
            <i class="fas fa-step-forward"></i>
        </div>
        <div class="progress-container">
            <span id="current-time">0:00</span>
            <div class="progress-bar" id="song-progress">
                <div class="progress"></div>
            </div>
            <span id="total-time">0:00</span>
        </div>
    </div>

    <div class="other-features">
        <div class="volume-bar">
            <i class="fas fa-volume-down" id="volume-icon"></i>
            <div class="progress-bar" id="volume-progress">
                <div class="progress" style="width: 100%;"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const audio = document.getElementById('audio-player');
    const playPauseBtn = document.querySelector('.play-pause');
    const progressBar = document.querySelector('#song-progress .progress');
    const songProgress = document.getElementById('song-progress');
    const volumeProgress = document.getElementById('volume-progress');
    const volumeProgressBar = volumeProgress.querySelector('.progress');
    const volumeIcon = document.getElementById('volume-icon');
    const currentTimeSpan = document.getElementById('current-time');
    const totalTimeSpan = document.getElementById('total-time');
    const titleEl = document.querySelector('.song-description .title');
    const artistEl = document.querySelector('.song-description .artist');
    const coverImg = document.querySelector('.image-container img');

    let isPlaying = false;
    let previousVolume = 100;

    // Time formatter
    function formatTime(seconds) {
        const min = Math.floor(seconds / 60);
        const sec = Math.floor(seconds % 60);
        return `${min}:${sec.toString().padStart(2, '0')}`;
    }

    // Volume Icon changer
    function updateVolumeIcon(volume) {
        volumeIcon.className = 'fas';
        if (volume === 0) {
            volumeIcon.classList.add('fa-volume-mute');
        } else if (volume < 0.5) {
            volumeIcon.classList.add('fa-volume-down');
        } else {
            volumeIcon.classList.add('fa-volume-up');
        }
    }

    // Make any progress bar draggable
    function makeDraggable(bar, callback) {
        let isDragging = false;

        bar.addEventListener('mousedown', () => {
            isDragging = true;
        });

        document.addEventListener('mousemove', (e) => {
            if (isDragging) {
                const rect = bar.getBoundingClientRect();
                let percent = (e.clientX - rect.left) / rect.width;
                percent = Math.max(0, Math.min(1, percent));
                callback(percent);
            }
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
        });

        // Also handle direct click
        bar.addEventListener('click', (e) => {
            const rect = bar.getBoundingClientRect();
            let percent = (e.clientX - rect.left) / rect.width;
            percent = Math.max(0, Math.min(1, percent));
            callback(percent);
        });
    }

    // Progress bar dragging logic
    makeDraggable(songProgress, (percent) => {
        audio.currentTime = percent * audio.duration;
    });

    // Volume bar dragging logic
    makeDraggable(volumeProgress, (percent) => {
        volumeProgressBar.style.width = `${percent * 100}%`;
        audio.volume = percent;
        updateVolumeIcon(percent);
    });

    // Toggle mute on icon click
    volumeIcon.addEventListener('click', () => {
        if (audio.volume > 0) {
            previousVolume = audio.volume;
            audio.volume = 0;
            volumeProgressBar.style.width = '0%';
        } else {
            audio.volume = previousVolume;
            volumeProgressBar.style.width = `${previousVolume * 100}%`;
        }
        updateVolumeIcon(audio.volume);
    });

    // Play/Pause toggle
    playPauseBtn.addEventListener('click', () => {
        if (!audio.src) return;
        if (audio.paused) {
            audio.play();
        } else {
            audio.pause();
        }
    });

    // Update play/pause icon on events
    audio.addEventListener('play', () => {
        isPlaying = true;
        playPauseBtn.classList.remove('fa-play');
        playPauseBtn.classList.add('fa-pause');
    });

    audio.addEventListener('pause', () => {
        isPlaying = false;
        playPauseBtn.classList.remove('fa-pause');
        playPauseBtn.classList.add('fa-play');
    });

    // Update time & progress
    audio.addEventListener('timeupdate', () => {
        const current = audio.currentTime;
        const total = audio.duration || 1;
        const percent = (current / total) * 100;
        progressBar.style.width = percent + '%';
        currentTimeSpan.textContent = formatTime(current);
        totalTimeSpan.textContent = formatTime(total);
    });

    // Handle click from .play-song elements
    document.addEventListener('click', function (e) {
        const item = e.target.closest('.play-song');
        if (!item) return;

        const title = item.dataset.title;
        const artist = item.dataset.artist;
        const cover = item.dataset.cover;
        const src = item.dataset.src;

        titleEl.textContent = title;
        artistEl.textContent = artist;
        coverImg.src = cover;
        audio.src = src;
        audio.play();
    });

    // Optional: Skip forward/backward (use as needed)
    document.querySelector('.fa-step-forward')?.addEventListener('click', () => {
        audio.currentTime += 10;
    });

    document.querySelector('.fa-step-backward')?.addEventListener('click', () => {
        audio.currentTime = Math.max(0, audio.currentTime - 10);
    });

//main page arist song player 
function playSong(filePath, cover, title) {
    // Assuming your music-player2.php has an audio element with id="audioPlayer"
    const audio = document.getElementById('audioPlayer');
    const source = document.getElementById('audioSource');

    source.src = filePath;
    audio.load();
    audio.play();

    // Optionally update UI (cover, title, etc.)
    document.getElementById('playerCover').src = cover;
    document.getElementById('playerTitle').textContent = title;
}

function playSong(file, title, id) {
    const audio = document.getElementById('audio-element'); // your custom player
    const source = document.getElementById('audio-source');
    const songTitle = document.getElementById('current-song-title');

    source.src = 'uploads/' + file;
    audio.load();
    audio.play();

    // Optional UI updates
    if (songTitle) {
        songTitle.textContent = title;
    }

    // Update play/pause buttons, highlight current song, etc.
}

</script>

   </body>
</html>