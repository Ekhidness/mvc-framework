<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'Departments';
    protected $primaryKey = 'DepartmentID';
    public $timestamps = false;
    protected $fillable = ['DepartmentName', 'DepartmentTypeID'];

    public function departmentType()
    {
        return $this->belongsTo(DepartmentType::class, 'DepartmentTypeID', 'DepartmentTypeID');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class, 'DepartmentID', 'DepartmentID');
    }

    public function subscribersThroughRooms()
    {
        return $this->hasManyThrough(Subscriber::class, Room::class, 'DepartmentID', 'SubscriberID', 'DepartmentID', 'RoomID');
    }
}