<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use SoftDeletes;
    
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');

    }

    public function scopeSearch($query, $target)
    {
        if ($target != '') {
            return $query->where('ticket_pedido', 'like', "%$target%")
            ->orWhereHas(
                'user',
                function ($query) use ($target) {
                    $query->where('name', 'like', '%'.$target.'%')
                        ->orWhere('email', 'like', '%'.$target.'%');
                }
            );
        }

    }
}
