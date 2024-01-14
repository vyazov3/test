<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chat extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $table = 'chats';

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'chat_users');
    }

}
