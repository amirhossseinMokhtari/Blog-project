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

class CreatePost
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    private $post;

    /**
     * Create a new event instance.
     */
    public function __construct(Post $newPost)
    {
        $this->post=$newPost;
    }
public function EmailMessage(){

return [

    'id' => $this->id,
    'title' => $this->title,
    'body' => $this->body,
    'study_time_in_min' => $this->study_time_in_min
];
}   /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
