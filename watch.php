<?php
$hideNav = true;
require_once("includes/header.php");

if (!isset($_GET["id"])) {
    ErrorMessage::show("No ID passed into page");
}

$user = new User($con, $userLoggedIn);
if(!$user->getisSubscribed()) {
    ErrorMessage::show("You must be Subscribed to see this.
                        <a href='profile.php'>Click here to subscribe</a>");
}

$video = new Video($con, $_GET["id"]);
$video->incrementViews();

$upNextVideo = VideoProvider::getUpNext($con, $video); // Fixed typo here

?>

<div class="watchContainer">

<div class="videoControls watchNav">
    <button onclick="goBack()"><i class="fas fa-arrow-left"></i></button>
    <h1><?php echo htmlspecialchars($video->getTitle()); ?></h1>
</div>

<div class="videoControls upNext" style="display:none;">

    <button onclick="restartVideo();"><i class="fas fa-redo"></i></button>

    <div class="upNextContainer">
        <h2>Up next:</h2>
        <h3><?php echo $upNextVideo->getTitle(); ?></h3> <!-- Fixed opening <h3> tag -->
        <h3><?php echo $upNextVideo->getSeasonAndEpisode(); ?></h3> <!-- Corrected tag -->

        <button class="playNext" onclick="watchVideo(<?php echo $upNextVideo->getId();?>)">
        <i class="fas fa-play"></i> Play
        </button>
    </div>

</div>

<video controls autoplay onended="showUpNext()">
    <source src='<?php echo htmlspecialchars($video->getFilePath()); ?>' type="video/mp4">
</video>

</div>
<script>
initVideo("<?php echo $video->getId(); ?>", "<?php echo $userLoggedIn; ?>");
</script>