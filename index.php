<!DOCTYPE html>
<html>
<!--
<style>
.container {
    height: 1080px;
    position: relative;
}

.center {
    margin: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
}
</style>
-->

<body>
    <div class = "container">
        <div class = "center">
            <div id = "gif_space"></div>
        </div>
    </div>
</body>

<!-- GIF Stuff -->
<script>
    function show_image(gif_name) {
        var img = document.createElement("img");
        img.src = "gifs/" + gif_name;
        img.width = 500;
        img.alt = "alt text";
        img.id = "deleteThis"
        document.getElementById('gif_space').appendChild(img)
    }

    function remove_image() {
        var image_x = document.getElementById('deleteThis');
        image_x.parentNode.removeChild(image_x); 
    }

    function play_gif(gif_name) {
        show_image(gif_name);
        setTimeout(() => {
            remove_image();
        }, 5000);
    }
</script>

<!-- Twitch API Stuff -->

<!-- Obtained from https://github.com/tmijs/tmi.js -->
<script src="tmi.min.js"></script>
<script>

    // Define configuration options
    const options = {
        channels: [
            "WhiteWolf_Kevin"
        ]
    };

    var client = new tmi.client(options);
    
    client.connect();

    client.on('message', (channel, tags, message, self) => {
        // "Alca: Hello, World!"
        // console.log(`${tags['display-name']}: ${message}`);
        console.log("There was a message");
        if (`${message}` == "!zerotwo") {
            console.log("Play Zero Two Gif");
            play_gif("alert_zero_two.gif");
        } else if (`${message}` == "!rikka") {
            console.log("Play Rikka Gif");
            play_gif("rikka_finger_spin.gif");
        } else if (`${message}` == "!konosuba") {
            console.log("Play Konosuba Gif");
            play_gif("konosuba.gif");
        } else if (`${message}` == "!aqua") {
            console.log("Play Aqua Gif");
            play_gif("aqua.gif");
        } else if (`${message}` == "!megumin") {
            console.log("Play megumin Gif");
            play_gif("megumin.gif");
        } else {
            console.log(`${tags['display-name']}: ${message}`);
        }
    });

</script>

</html>