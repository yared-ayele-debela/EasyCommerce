<?php
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;

class DeliveryManLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

     public $id, $lat, $lng;

    public function __construct($id, $lat, $lng)
    {
        $this->id = $id;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('deliveryman.location.' . $this->id);
    }

    public function broadcastAs()
    {
        return 'LocationUpdated';
    }
}