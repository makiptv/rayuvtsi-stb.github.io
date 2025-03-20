<?php
$channelId = $_GET['id'];
$channelsData = json_decode(file_get_contents('ott-3.json'), true);
$selectedChannel = null;
foreach ($channelsData as $channel) {
  if ($channel['name'] == $channelId) {
    $selectedChannel = $channel;
    break;
  }
}
if (!$selectedChannel) {
  echo 'Error: Invalid channel ID';
  exit;
}
$videoUrl = $selectedChannel['url'];
$logoUrl = $selectedChannel['logo'];
$videoTitle = $selectedChannel['name'];
?>
<html>

<head>
<title>RAYUVTSI-STB</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1" /> 
<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="shortcut icon" type="image/x-icon" href="https://res.cloudinary.com/live4web/image/upload/v1679110243/player_watermark.png">
<script src="https://raw.githubusercontent.com/ghouet/chrome-hls/refs/heads/master/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/1.3.8/FileSaver.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.37.5/ace.js"></script>
<script src="https://raw.githubusercontent.com/ghouet/chrome-hls/refs/heads/master/hlsjs/hls.1.4.12.min.js"></script>
<style>
html {
  font-family: Poppins;
  background: #000;
  margin: 0;
  padding: 0
}

.loading {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #000;
        z-index: 9999;
    }
    
    .loading-text {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
        text-align: center;
        width: 100%;
        height: 100px;
        line-height: 100px;
    }
    
    .loading-text span {
        display: inline-block;
        margin: 0 5px;
        color: #ffffff;
        font-family: 'Quattrocento Sans', sans-serif;
    }
    
    .loading-text span:nth-child(1) {
        filter: blur(0px);
        animation: blur-text 1.5s 0s infinite linear alternate;
    }
    
    .loading-text span:nth-child(2) {
        filter: blur(0px);
        animation: blur-text 1.5s 0.2s infinite linear alternate;
    }
    
    .loading-text span:nth-child(3) {
        filter: blur(0px);
        animation: blur-text 1.5s 0.4s infinite linear alternate;
    }
    
    .loading-text span:nth-child(4) {
        filter: blur(0px);
        animation: blur-text 1.5s 0.6s infinite linear alternate;
    }
    
    .loading-text span:nth-child(5) {
        filter: blur(0px);
        animation: blur-text 1.5s 0.8s infinite linear alternate;
    }
    
    .loading-text span:nth-child(6) {
        filter: blur(0px);
        animation: blur-text 1.5s 1s infinite linear alternate;
    }
    
    .loading-text span:nth-child(7) {
        filter: blur(0px);
        animation: blur-text 1.5s 1.2s infinite linear alternate;
    }
    
    @keyframes blur-text {
        0% {
            filter: blur(0px);
        }
        100% {
            filter: blur(4px);
        }
    }
    .plyr__video-wrapper::before {
        position: absolute;
        top: 10px;
        left: 20px;
        z-index: 10;
        content: '';
        height: 35px;
        width: 75px;
        background: url('tag.png') no-repeat;
        background-size: 75px auto, auto;
    }
    :root {
--plyr-color-main: #d9230f;}

</style>

</head>
<body>
    
    
  <div id="loading" class="loading">
<div class="loading-text">
<B>
<span class="loading-text-words">R</span>
<span class="loading-text-words">A</span>
<span class="loading-text-words">Y</span>
<span class="loading-text-words">U</span>
<span class="loading-text-words">V</span>
<span class="loading-text-words">T</span>
<span class="loading-text-words">S</span>
<span class="loading-text-words">I</span>
<span class="loading-text-words">S</span>
<span class="loading-text-words">T</span>
<span class="loading-text-words">B</span></B>
</div>
</div>
    <script>(function(w,q){w[q]=w[q]||[];w[q].push(["_mgc.load"])})(window,"_mgq");
    </script>

<video autoplay controls crossorigin poster="http://jiotv.catchup.cdn.jio.com/dare_images/images/<?php echo $_REQUEST["c"]; ?>.png" playsinline>

<?php

printf("<source type="application/vnd.apple.mpegurl" src="<?php echo $videoUrl; ?>", $_REQUEST["c"]);

?>

</video>

</body>

<script>

setTimeout(videovisible, 3000)



function videovisible() {

    document.getElementById('loading').style.display = 'none'

}

document.addEventListener("DOMContentLoaded", () => {

    const e = document.querySelector("video"),

        n = e.getElementsByTagName("source")[0].src,

        o = {};

    if (Hls.isSupported()) {

        var config = {

            maxMaxBufferLength: 100,

        };

        const t = new Hls(config);

        t.loadSource(n), t.on(Hls.Events.MANIFEST_PARSED, function(n, l) {

            const s = t.levels.map(e => e.height);

            o.quality = {

                default: s[0],

                options: s,

                forced: !0,

                onChange: e => (function(e) {

                    window.hls.levels.forEach((n, o) => {

                        n.height === e && (window.hls.currentLevel = o)

                    })

                })(e)

            };

            new Plyr(e, o)

        }), t.attachMedia(e), window.hls = t

    } else {

        new Plyr(e, o)

    }

});

</script>

<script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"rayId":"922f7a82ff0a5a8a","version":"2025.1.0","r":1,"token":"1eaa94dc0d534aaaa04c4d19fd3a7785","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}}}' crossorigin="anonymous"></script>
</body>
</html>
