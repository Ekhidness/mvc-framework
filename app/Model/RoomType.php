<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'RoomTypes';
    protected $primaryKey = 'RoomTypeID';
    public $timestamps = false;
    protected $fillable = ['RoomTypeName'];
}