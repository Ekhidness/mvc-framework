<?php
namespace Controller;

use Model\Department;
use Model\Room;
use Model\RoomType;
use Src\Request;
use Src\View;
use Validators\RoomValidator;

class RoomController
{
    public function index(): string
    {
        return (new View())->render('room.index', ['rooms' => Room::with(['type', 'department'])->get()]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = RoomValidator::make($request->all());
            if ($validator->fails()) {
                return (new View())->render('room.create', [
                    'types' => RoomType::all(),
                    'departments' => Department::all(),
                    'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)
                ]);
            }
            Room::create($request->all());
            app()->route->redirect('/sys/rooms');
            return false;
        }
        return (new View())->render('room.create', ['types' => RoomType::all(), 'departments' => Department::all()]);
    }
}