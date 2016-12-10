<?php

namespace App;

use App\Post;
use App\Topic;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'content_id', 'type',
    ];

    /**
     * Each Report belongs to a User.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns true if a Report belongs to a Post.
     *
     * @return boolean
     */
    public function isPost()
    {
        return (str_replace('App\\', '', $this->type) === 'Post') ? true : false;
    }

    /**
     * Returns a Post, based on its id.
     *
     * @param  int    $postId
     * @return App\Post
     */
    protected function getPost(int $postId)
    {
        return Post::where('id', $postId)->first();
    }

    /**
     * Returns a the slug of a Topic, that a Post belongs to.
     *
     * @return string
     */
    public function getTopicForPost(int $postId)
    {
        $post = $this->getPost($postId);
        return $post->topic->slug;
    }

    /**
     * Returns the slug of a Topic.
     *
     * @return string
     */
    public function getTopicSlug()
    {
        return Topic::where('id', $this->content_id)->first()->slug;
    }

    /**
     * Returns the body of a Post.
     *
     * @return string
     */
    public function getPostBody(int $postId)
    {
        return $this->getPost($postId)->body;
    }

    /**
     * Returns whether a Topic or Post exists.
     *
     * @return mixed App\Post | App\Topic
     */
    public function contentExists()
    {
        if ($this->isPost()) {
            return Post::where('id', $this->content_id)->first();
        } else {
            return Topic::where('id', $this->content_id)->first();
        }
    }

}
