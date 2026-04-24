<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $table = 'Subscribers';
    protected $primaryKey = 'SubscriberID';
    public $timestamps = false;
    
    protected $fillable = [
        'Surname',
        'Name',
        'Patronymic',
        'BirthdayDate',
        'Photo'
    ];

    public function phones()
    {
        return $this->hasMany(Phone::class, 'SubscriberID', 'SubscriberID');
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->whereHas('phones', function ($q) use ($departmentId) {
            $q->whereHas('room', function ($qRoom) use ($departmentId) {
                $qRoom->where('DepartmentID', $departmentId);
            });
        });
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('Surname', 'like', "%$term%")
              ->orWhere('Name', 'like', "%$term%")
              ->orWhere('Patronymic', 'like', "%$term%");
        });
    }

    public static function getFilteredList($searchTerm = null, $departmentId = null)
    {
        $query = self::with(['phones.room.department']); 
        
        if ($searchTerm) {
            $query->search($searchTerm);
        }
        
        if ($departmentId) {
            $query->byDepartment($departmentId);
        }
        
        return $query->get();
    }
}