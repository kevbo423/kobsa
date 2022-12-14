<!DOCTYPE html>
<html>
<style>
    .gif_space {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 1080px;
    }
</style>

<body>
    <div class = "gif_space" id = "gif_space"></div>
</body>


<!-- PHP to get the array of GIFs -->
<?php

    // Specify the gifs and mp3s directory paths
    $gifs_directory = "./gifs";
    $mp3s_directory = "./mp3s";

    // Generate the arrays based on all of the files in the directories and remove '.' and '..'
    $gifs = array_diff(scandir($gifs_directory), array('..', '.'));
    $mp3s = array_diff(scandir($mp3s_directory), array('..', '.'));

    // Reset the array indexes after removing '.' and '..'
    $gifs = array_values($gifs);
    $mp3s = array_values($mp3s);

    // Remove the file extensions
    $gifs = array_map(function($e){
        return pathinfo($e, PATHINFO_FILENAME);
    }, $gifs);

    $mp3s = array_map(function($e){
        return pathinfo($e, PATHINFO_FILENAME);
    }, $mp3s);

    /* Debug to display contents of array
    foreach ($gifs as $gif) {
        print("$gif</br>");
    }
    */

?>


<!-- GIF Stuff -->
<script>
    
    // Customizable configuration
    var max_gif_width = 500; // Default is 500

    var gif_playing = false;

    function show_image(gif_name) {
        var img = document.createElement("img");
        img.src = "gifs/" + gif_name;
        img.width = max_gif_width;
        img.alt = "alt text";
        img.id = "deleteThis";
        document.getElementById('gif_space').appendChild(img);
    }

    function remove_image() {
        var image_x = document.getElementById('deleteThis');
        image_x.parentNode.removeChild(image_x); 
    }

    function play_gif(gif_name) {
        gif_playing = true;

        show_image(gif_name);
        setTimeout(() => {
            remove_image();
            gif_playing = false;
        }, 5000);
    }

    function play_mp3(mp3_name) {
        new Audio("mp3s/" + mp3_name).play()
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

    // Getting array of GIFs and MP3s from PHP
    var gifs_array = <?php echo json_encode($gifs); ?>;
    var mp3s_array = <?php echo json_encode($mp3s); ?>;

    // Debug info
    // gifs_array.forEach(element => document.write(element + "<br/>"));
    // console.log(gifs_array);


    // Client connection stuff
    var client = new tmi.client(options);
    client.connect();
    client.on('message', (channel, tags, message, self) => {

    // Continue if a command is sent
    if (`${message}`.startsWith("!") ) {
        //console.log(`${tags['display-name']}: ${message}`);

        user_message = `${message}`.replace('!', '');

        if (gifs_array.includes(user_message)) {
            if (gif_playing == false) {
                console.log("Play " + user_message + ".gif");
                play_gif(user_message + ".gif");
            } else {
                console.log("Can't play! GIF already playing!");
            }
        } else {
            console.log("NOT A GIF!!!");
        }

        if (mp3s_array.includes(user_message)) {
            console.log("Play " + user_message + ".mp3");
            play_mp3(user_message + ".mp3");
        } else {
            console.log("NOT A MP3!!!");
        }
    }

    });

</script>
</html>