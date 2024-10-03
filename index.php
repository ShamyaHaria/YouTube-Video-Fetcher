<?php
require_once "class.youtube.php";
$yt  = new YouTubeDownloader();
$downloadLinks ='';
$error='';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $videoLink = $_POST['video_link'];
    if(!empty($videoLink)) {
        $vid = $yt->getYouTubeCode($videoLink);
        if($vid) {
            $result = $yt->processVideo($vid);
            
            if($result) {
                // Get video info and formats
                $info = $result['videos']['info'];
                $formats = $result['videos']['formats'];
                $adapativeFormats = $result['videos']['adapativeFormats'];
                $videoInfo = json_decode($info['player_response']);
                $title = $videoInfo->videoDetails->title;
                $thumbnail = $videoInfo->videoDetails->thumbnail->thumbnails[0]->url;
            } else {
                $error = "Something went wrong";
            }
        }
    } else {
        $error = "Please enter a YouTube video URL";
    }
}
?>
<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Download YouTube Video</title>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400&display=swap" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .formSmall {
            width: 700px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .youtube-icon {
            margin-right: 10px;
            width: 50px;
            height: 50px;
        }
        .github-icon {
            width: 40px;
            height: 40px;
            margin-top: 30px;
        }
        .input-group {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            border-radius: 30px;
        }
        .form-control {
            border-radius: 30px 0 0 30px;
            padding: 20px;
        }
        .btn-primary {
            border-radius: 0 30px 30px 0;
            background-color: #ff0000;
            border: none;
            padding: 10px 30px;
        }
        .btn-primary:hover {
            background-color: #cc0000;
        }
        .card {
            margin-top: 20px;
        }
        .card-header {
            background-color: #ff0000;
            color: #fff;
        }
        .card-body {
            background-color: #f9f9f9;
        }
        h7 {
            font-size: 1.5rem;
            color: #ff0000;
            text-align: center;
            font-weight: bold;
        }
        a {
            color: #ff0000;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="post" action="" class="formSmall">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h7> 
                        <img class="youtube-icon" src="https://static.vecteezy.com/system/resources/thumbnails/023/986/480/small_2x/youtube-logo-youtube-logo-transparent-youtube-icon-transparent-free-free-png.png" alt="YouTube Logo"> 
                        Download YouTube Video
                    </h7>
                </div>
                <div class="col-lg-12">
                    <div class="input-group">
                        <input type="text" class="form-control" name="video_link" placeholder="Paste link.. e.g. https://www.youtube.com/watch?v=OK_JCtrrv-c">
                        <span class="input-group-btn">
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Go!</button>
                        </span>
                    </div>
                </div>
            </div>
        </form>

        <?php if($error) :?>
            <div style="color:red;font-weight: bold;text-align: center"><?php print $error?></div>
        <?php endif;?>

        <?php if(!empty($formats)):?>
        <div class="row formSmall">
            <div class="col-lg-3">
                <img src="<?php print $thumbnail?>">
            </div>
            <div class="col-lg-9">
                <?php print $title?>
            </div>
        </div>

        <div class="card formSmall">
            <div class="card-header">
                <strong>With Video & Sound</strong>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Type</td>
                        <td>Quality</td>
                        <td>Download</td>
                    </tr>
                    <?php foreach ($formats as $video) :?>
                        <tr>
                            <td><?php print $video['type']?></td>
                            <td><?php print $video['quality']?></td>
                            <td><a href="downloader.php?link=<?php print urlencode($video['link'])?>&title=<?php print urlencode($title)?>&type=<?php print urlencode($video['type'])?>">Download</a> </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>

        <div class="card formSmall">
            <div class="card-header">
                <strong>Video only / Audio only</strong>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Type</td>
                        <td>Quality</td>
                        <td>Download</td>
                    </tr>
                    <?php foreach ($adapativeFormats as $video) :?>
                        <tr>
                            <td><?php print $video['type']?></td>
                            <td><?php print $video['quality']?></td>
                            <td><a href="downloader.php?link=<?php print urlencode($video['link'])?>&title=<?php print urlencode($title)?>&type=<?php print urlencode($video['type'])?>">Download</a> </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
        <?php endif;?>

        <!-- GitHub Icon and Link -->
        <div class="text-center">
            <a href="https://github.com/ShamyaHaria" target="_blank">
                <img class="github-icon" src="https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg" alt="GitHub Icon">
            </a>
            <p>Feel free to ask any queries or suggest corrections</p>
        </div>
    </div>
</body>
</html>