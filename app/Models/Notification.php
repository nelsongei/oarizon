<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{


    protected $table = 'notifications';

    // Add your validation rules here
    public static $rules = [
        // 'title' => 'required'
    ];

    // Don't forget to fill this array
    protected $fillable = [];


    public static function notifyUser($userid, $message, $type, $about = 'none', $target = 'none', $link, $key)
    {

        $notification = new Notification;

        $notification->user_id = $userid;
        $notification->message = $message;
        $notification->is_read = 0;
        $notification->type = $type;
        $notification->about = $about;
        $notification->target = $target;
        $notification->link = $link;
        $notification->not_period = 1;
        $notification->confirmation_code = $key;
        $notification->save();

    }


}
