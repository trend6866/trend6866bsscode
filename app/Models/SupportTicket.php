<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'ticket_id',
        'user_id',
        'title',
        'description',
        'attachment',
        'answer',
        'status',
        'theme_id',
        'store_id',
        'created_by'
    ];

    public function UserData()
    {
        return $this->hasOne(User::class, 'id',
        'user_id');
    }

    public function conversions()
    {
        return $this->hasMany('App\Models\SupportConversion', 'ticket_id', 'id')->orderBy('id');
    }



    public static function ticket_status_change($date = [])
    {
        $ticket_id = $date['ticket_id'];
        $ticket_status = $date['ticket_status'];

        $ticket = SupportTicket::find($ticket_id);
        if(!empty($ticket)) {
            if($ticket_status == 'open' ) {
                $ticket->status = $ticket_status;
                $ticket->save();

                $return['status'] = 'success';
                $return['message'] = 'Ticket status changed.';
                return $return;
            }
            if($ticket_status == 'In Progress') {
                $ticket->status = $ticket_status;
                $ticket->save();

                $return['status'] = 'success';
                $return['message'] = 'Ticket status changed.';
                return $return;
            }

            if($ticket_status ==  'Solved')
            {

                $ticket->status = $ticket_status;
                $ticket->save();

                $return['status'] = 'success';
                $return['message'] = 'Ticket status changed.';
                return $return;
            }
        } else {
            $return['status'] = 'error';
            $return['message'] = 'Ticket not found.';
            return $return;
        }
    }
}
