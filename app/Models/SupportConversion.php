<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportConversion extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'description',
         'attachments',
         'sender',
         'theme_id',
         'store_id',
         'user_id'
    ];

    public function replyBy(){
        if($this->sender=='user'){
            // return $this->ticket;
            return $this->hasOne('App\Models\User','id','user_id')->first();
        }
        else{
            return $this->hasOne('App\Models\Admin','id','sender')->first();
        }
    }

    public function ticket(){
        return $this->hasOne('App\Models\SupportTicket','id','ticket_id');
    }

    public  static function change_status($ticket_id)
    {
        // dd($ticket_id);

        $ticket = SupportConversion::find($ticket_id);
        $ticket->status = 'In Progress';
        $ticket->update();
        return $ticket;
    }
}
