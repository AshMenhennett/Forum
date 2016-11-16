<p>
    A user posted on '{{ $topic->title }}'. We thought you would like to know.
    <br />
    Check it out <a href="{{ env('APP_URL') . '/forum/topics/' . $topic->slug . '#post-' . $post->id}}">here</a>.
</p>
<p>
    Regards,
    <br />
    Admin @ {{ env('APP_NAME') }}.
</p>
