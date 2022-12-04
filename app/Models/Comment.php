<?php

namespace App\Models;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'body'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}