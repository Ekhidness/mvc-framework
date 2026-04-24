<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'Phones';
    protected $primaryKey = 'PhoneID';
    public $timestamps = false;
    protected $fillable = ['Number', 'RoomID', 'SubscriberID'];

    public function room()
    {
        return $this->belongsTo(Room::class, 'RoomID', 'RoomID');
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class, 'SubscriberID', 'SubscriberID');
    }

    public function scopeFree($query)
    {
        return $query->whereNull('SubscriberID');
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->whereHas('room', function ($q) use ($departmentId) {
            $q->where('DepartmentID', $departmentId);
        });
    }
}