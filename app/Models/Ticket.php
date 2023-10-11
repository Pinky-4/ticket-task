<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $guarded = [];
    protected $appends = ['created_date'];

    public function getUserInfo(){
        return $this->hasOne(User::class,'id','assigned_user_id');
    }

    public function getCreatedDateAttribute(){
        return $this->created_at ? Carbon::parse($this->created_at)->format('d-m-Y') : "-";
    }
}
