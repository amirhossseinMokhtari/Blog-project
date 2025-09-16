<?php

namespace App\Events;

use App\Models\Post;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PostCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

 private $newPost;
    public function __construct(Post $newPost)
    {
        $this->newPost = $newPost;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            'id'=>'Post with ID :'.$this->newPost->id,
            'user_id'=>' was created by user ID: ' .$this->newPost->user_id,
            'created_at'=> ' on: ' . $this->newPost->created_at,
            'title'=>' with the title: ' . $this->newPost->title,
        ];
    }
}
