<p>
    You have been mentioned by <a href="{{ env('APP_URL') . '/user/profile/@' . $post->user->name }}">{{ '@' . $post->user->name }}</a> in a post from the <a href="{{ env('APP_URL') . '/forum/topics/' . $topic->slug . '#post-' . $post->id }}">{{ $topic->title }}</a> topic @ {{ env('APP_NAME') }}.
</p>
<p>
    If the above links didn't work, please copy and paste the following URLs into your Browser's address bar: <em>{{ env('APP_URL') . '/user/profile/@' . $post->user->name }} and {{ env('APP_URL') . '/forum/topics/' . $topic->slug . '#post-' . $post->id }}</em>
</p>
<p>
    Regards,
    <br />
    Admin @ {{ env('APP_NAME') }}.
</p>
