<video data-video-id="{{$video->id}}" controls="controls">
    <source src="{{ empty($video->video_url) ? $video->getFileUrl() : $video->video_url }}" />
</video>