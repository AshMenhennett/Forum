<?php

namespace App;

use App\Post;
use App\Topic;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'user_id', 'content_id', 'type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPost()
    {
        return (str_replace('App\\', '', $this->type) === 'Post') ? true : false;
    }

    protected function getPost(int $postId)
    {
        return Post::where('id', $postId)->first();
    }

    public function getTopicForPost(int $postId)
    {
        $post = $this->getPost($postId);
        return $post->topic->slug;
    }

    public function getTopicSlug()
    {
        return Topic::where('id', $this->content_id)->first()->slug;
    }

    public function getPostBody(int $postId)
    {
        return $this->getPost($postId)->body;
    }

    public function contentExists()
    {
        if ($this->isPost()) {
            return Post::where('id', $this->content_id)->first();
        } else {
            return Topic::where('id', $this->content_id)->first();
        }
    }

}
