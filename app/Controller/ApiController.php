<?php
namespace Controller;

use Src\Request;
use Src\View;
use Model\User;
use Model\Subscriber;
use Model\Phone;
use Model\Department;

class ApiController
{
    protected function json(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    public function login(Request $request): void
    {
        if ($request->method !== 'POST') {
            $this->json(['error' => 'Method not allowed'], 405);
        }

        $data = $request->all();
        $login = trim($data['login'] ?? '');
        $password = trim($data['password'] ?? '');

        $user = User::where('Login', $login)->first();

        if (!$user || md5($password) !== $user->PasswordHash) {
            $this->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->generateApiToken();

        $this->json([
            'token' => $token,
            'expires_in' => 86400,
            'user_id' => $user->UserID
        ]);
    }

    public function subscribers(Request $request): void
    {
        $list = Subscriber::with(['phones'])->get()->map(function ($s) {
            return [
                'id' => $s->SubscriberID,
                'surname' => $s->Surname,
                'name' => $s->Name,
                'patronymic' => $s->Patronymic,
                'birthday' => $s->BirthdayDate,
                'phones' => $s->phones->pluck('Number')->toArray()
            ];
        });

        $this->json(['subscribers' => $list]);
    }

    public function phones(Request $request): void
    {
        $list = Phone::with(['room.department', 'subscriber'])->get()->map(function ($p) {
            return [
                'id' => $p->PhoneID,
                'number' => $p->Number,
                'room' => $p->room ? $p->room->RoomNumber : null,
                'department' => $p->room?->department?->DepartmentName,
                'subscriber' => $p->subscriber ? trim($p->subscriber->Surname . ' ' . $p->subscriber->Name) : null
            ];
        });

        $this->json(['phones' => $list]);
    }

    public function departments(Request $request): void
    {
        $list = Department::withCount('rooms')->get()->map(function ($d) {
            return [
                'id' => $d->DepartmentID,
                'name' => $d->DepartmentName,
                'type' => $d->departmentType?->DepartmentTypeName,
                'rooms_count' => $d->rooms_count
            ];
        });

        $this->json(['departments' => $list]);
    }

    public function index(): void
    {
        $this->json(['message' => 'API is working']);
    }

    public function echo(Request $request): void
    {
        $this->json($request->all());
    }
}