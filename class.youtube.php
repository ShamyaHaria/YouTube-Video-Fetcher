<?php
/**
 * YouTube Downloader Class
 */

class YouTubeDownloader {
    /**
     * Get the YouTube video ID from a video URL
     * @param $url
     * @return mixed
     */
    public function getYouTubeCode($url) {
        parse_str(parse_url($url, PHP_URL_QUERY), $vars);
        return $vars['v'];
    }

    /**
     * Process the video and return details of available formats
     * @param $vid
     * @return array|void
     */
    public function processVideo($vid) {
        // Retrieve video info from YouTube
        parse_str(file_get_contents("https://youtube.com/get_video_info?video_id=" . $vid), $info);

        $playabilityJson = json_decode($info['player_response']);
        $formats = $playabilityJson->streamingData->formats;
        $adaptiveFormats = $playabilityJson->streamingData->adaptiveFormats;

        // Check if the video is playable
        $isPlayable = $playabilityJson->playabilityStatus->status;

        // Log non-playable video info
        if (strtolower($isPlayable) != 'ok') {
            $log = date("c") . " " . $info['player_response'] . "\n";
            file_put_contents('./video.log', $log, FILE_APPEND);
        }

        $result = array();

        // Check if the video info is valid and playable
        if (!empty($info) && $info['status'] == 'ok' && strtolower($isPlayable) == 'ok') {
            $i = 0;
            foreach ($adaptiveFormats as $stream) {
                $streamUrl = $stream->url;
                $type = explode(";", $stream->mimeType);

                $qualityLabel = '';
                if (!empty($stream->qualityLabel)) {
                    $qualityLabel = $stream->qualityLabel;
                }

                $videoOptions[$i]['link'] = $streamUrl;
                $videoOptions[$i]['type'] = $type[0];
                $videoOptions[$i]['quality'] = $qualityLabel;
                $i++;
            }

            $j = 0;
            foreach ($formats as $stream) {
                $streamUrl = $stream->url;
                $type = explode(";", $stream->mimeType);

                $qualityLabel = '';
                if (!empty($stream->qualityLabel)) {
                    $qualityLabel = $stream->qualityLabel;
                }

                $videoOptionsOrg[$j]['link'] = $streamUrl;
                $videoOptionsOrg[$j]['type'] = $type[0];
                $videoOptionsOrg[$j]['quality'] = $qualityLabel;
                $j++;
            }

            $result['videos'] = array(
                'info' => $info,
                'adaptiveFormats' => $videoOptions,
                'formats' => $videoOptionsOrg
            );

            return $result;
        } else {
            return;
        }
    }
}