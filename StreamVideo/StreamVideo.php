<?php
/*
MIT License 

Copyright (c) 2024 Ramesh Jangid. 

Permission is hereby granted, free of charge, to any person obtaining a copy 
of this software and associated documentation files (the "Software"), to deal 
in the Software without restriction, including without limitation the rights 
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell 
copies of the Software, and to permit persons to whom the Software is 
furnished to do so, subject to the following conditions: 

The above copyright notice and this permission notice shall be included in all 
copies or substantial portions of the Software. 

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR 
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, 
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE 
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER 
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, 
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE 
SOFTWARE. 
*/ 

/*
 * Usage instructions:
 *
 * >>>>stream.html<<<<
 * <html>
 * <head></head>
 * <body>
 * <video  controls>
 *     <source src="/Stream.php?file=/somevideo.mov">   
 * </video>
 * </body>
 * </html>
 * 
 * >>>>Stream.php<<<<
 * <?php
 * include_once ('StreamVideo.php');
 *
 * $file = $_GET['file'];
 *
 * $obj = new StreamVideo();
 * $obj->initFile($file);
 * $obj->validateFile();
 * $obj->setHeaders();
 * $obj->streamContent();
 * ?>
 */

/**
 * Class to stream video contents on web.
 * 
 * @category   PHP Streaming Videos
 * @package    StreamVideo
 * @author     Ramesh Narayan Jangid
 * @copyright  Ramesh Narayan Jangid
 * @version    Release: @1.0.0@
 * @since      Class available since Release 1.0.0
 */
class StreamVideo
{
    /**
     * Video Folder
     * 
     * The folder location outside docroot
     * without a slash at the end
     * 
     * @var string
     */
    private $videosFolderLocation = 'D:\Movies';

    /**
     * Supported Video mime types
     * 
     * @var array
     */
    private $supportedMimes = [
        'video/quicktime'
    ];

    /**
     * Streamed Video cache duration.
     * 
     * @var integer
     */
    private $streamCacheDuration = 7 * 24 * 3600; // 1 week

    /**
     * File details required in class.
     */
    public $absoluteFilePath = "";
    public $fileName = "";
    public $fileMime = "";
    public $fileModifiedTimeStamp = 0;
    public $fileSize = 0;
    public $streamFrom = 0;
    public $streamTill = 0;

    /**
     * Initalise
     *
     * @param string $relativeFilePath File path in video folder with leading slash(/)
     * @return void
     */
    public function initFile($relativeFilePath)
    {
        // Check Range header
        $headers = getallheaders();
        if (!isset($headers['Range']) && strpos($headers['Range'], 'bytes=') !== false) {
            die('Invalid request.');
        }
        // Set buffer Range
        $range = explode('=', $headers['Range'])[1];
        list($this->streamFrom, $this->streamTill) = explode('-', $range);
        // Check path of file to be served
        $this->absoluteFilePath = $absoluteFilePath = $this->videosFolderLocation . $relativeFilePath;
        if (!is_file($absoluteFilePath)) {
            die('Invalid file.');
        }
        //Set details of file to be served.
        // Set file name
        $this->fileName = basename($absoluteFilePath);
        // Get file mime
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $this->fileMime = finfo_file($fileInfo, $absoluteFilePath);
        finfo_close($fileInfo);
        // Get file modified time
        $this->fileModifiedTimeStamp = filemtime($absoluteFilePath);
        // Get file size
        $this->fileSize = filesize($absoluteFilePath);
    }

    /**
     * Validate File related details
     *
     * @return void
     */
    public function validateFile()
    {
        if (!in_array($this->fileMime, $this->supportedMimes)) {
            die('Invalid mime.');
        }
        if ($this->streamFrom >= $this->fileSize ) {
            die('Invalid request.');
        }
    }
    
    /**
     * Set headers on successful validation
     *
     * @return void
     */
    public function setHeaders()
    {
        header('Content-Type: ' . $this->fileMime);
        header('Cache-Control: max-age=' . $this->streamCacheDuration . ', public');
        header('Expires: '.gmdate('D, d M Y H:i:s', time() + $this->streamCacheDuration) . ' GMT');
        header('Last-Modified: ' . gmdate("D, d M Y H:i:s", $this->fileModifiedTimeStamp) . ' GMT'); 
        header('Accept-Ranges: 0-' . ($this->fileSize - 1));
        if ($this->streamFrom == 0 && in_array($this->streamTill, ['', '1'])) {
            $this->streamTill = $this->fileSize - 1;
            header('Content-Length: ' . $this->fileSize);
        } else {
            $this->streamTill = ($this->streamTill == '') ? $this->fileSize - 1 : $this->streamTill;
            $streamSize = $this->streamTill - $this->streamFrom + 1;
            header('HTTP/1.1 206 Partial Content');
            header('Content-Length: ' . $streamSize);
            header('Content-Range: bytes ' . $this->streamFrom . '-' . $this->streamTill . '/' . $this->fileSize);
        }
    }

    /**
     * Stream video file content
     *
     * @return void
     */
    public function streamContent()
    {
        if (!($srcStream = fopen($this->absoluteFilePath, 'rb'))) {
            die('Could not open stream for reading');
        }
        $destStream = fopen('php://output', 'wb');
        $totalBytes = $this->streamTill - $this->streamFrom + 1;
        stream_copy_to_stream($srcStream, $destStream, $totalBytes, $this->streamFrom);
        fclose($destStream);
        fclose($srcStream);
    }
}
