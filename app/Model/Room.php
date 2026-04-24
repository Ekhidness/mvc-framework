<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'Rooms';
    protected $primaryKey = 'RoomID';
    public $timestamps = false;
    protected $fillable = ['RoomNumber', 'RoomTypeID', 'DepartmentID', 'UserID'];

    public function type()
    {
        return $this->belongsTo(RoomType::class, 'RoomTypeID', 'RoomTypeID');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'DepartmentID', 'DepartmentID');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'RoomID', 'RoomID');
    }
}