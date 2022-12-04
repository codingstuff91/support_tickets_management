<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description', 
        'priority',
        'status',
        'user_id',
        'agent_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopePersonnal($query)
    {
        $query->where('user_id', Auth::user()->id);
    }

    public function scopeOpen($query)
    {
        $query->where('status','open');
    }
}
