<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'limit_days'];

    public function leaveRequests(){
        return $this->hasMany(LeaveRequest::class);
    }
}
