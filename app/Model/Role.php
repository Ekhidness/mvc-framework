<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'Roles';
    protected $primaryKey = 'RoleID';
    public $timestamps = false;
    protected $fillable = ['RoleName'];
}