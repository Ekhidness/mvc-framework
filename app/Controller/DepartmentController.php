<?php
namespace Controller;

use Model\Department;
use Model\DepartmentType;
use Src\Request;
use Src\View;
use Validators\DepartmentValidator;

class DepartmentController
{
    public function index(): string
    {
        $departments = Department::with(['departmentType'])->withCount('rooms')->get();
        return (new View())->render('department.index', ['departments' => $departments]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = DepartmentValidator::make($request->all());
            if ($validator->fails()) {
                return (new View())->render('department.create', [
                    'types' => DepartmentType::all(),
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }
            Department::create($request->all());
            app()->route->redirect('/sys/departments');
            return false;
        }
        return (new View())->render('department.create', ['types' => DepartmentType::all()]);
    }
}