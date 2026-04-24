<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class DepartmentType extends Model
{
    protected $table = 'DepartmentTypes';
    protected $primaryKey = 'DepartmentTypeID';
    public $timestamps = false;
    protected $fillable = ['DepartmentTypeName'];
}