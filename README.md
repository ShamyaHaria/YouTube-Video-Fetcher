# YouTube Video Fetcher
YouTube Video Fetcher is a simple PHP application to extract and download YouTube videos. It fetches available formats (both video and audio) and provides download links in various qualities. This tool uses the YouTube Data API v3 for retrieving video details.

## Features
 - Extract video formats (with video and audio) and adaptive formats
   (audio or video only). 
 - Download YouTube videos in multiple
   resolutions and formats. 
- Minimal interface for easy link input and
   download. 
- Logs errors related to non-playable videos.

## Installation
1. Set up your server:
	If using XAMPP, place the files in the htdocs folder
2. Ensure file write permissions are granted to log errors:
	sudo chmod 777 ./video.log
3. Get a YouTube Data API v3 key from Google Cloud Console and replace the API call section accordingly.

## Usage
1. Open index.php in your browser:
	http://localhost/youtube-video-fetcher/index.php
2. Paste the YouTube video URL in the input field and click "Go."
3. The application will display available formats and resolutions. 
4. Click the download link to start the download.

## File Structure
1. index.php: Main entry point with the form to input YouTube video URLs and display available download options.
2. class.youtube.php: Contains the logic to fetch video formats, parse video info, and handle errors.
3. downloader.php: Handles the downloading of selected video formats.

## Dependencies
- PHP (version 7.4 or above)
- XAMPP (for running locally, or any other PHP server)

**License**
<br>This project is licensed under the MIT License.

