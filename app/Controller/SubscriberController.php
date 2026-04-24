<?php
namespace Controller;

use Model\Department;
use Model\Subscriber;
use Src\Request;
use Src\View;
use Validators\SubscriberValidator;
use Validators\ImageValidator;

class SubscriberController
{
    public function index(Request $request): string
    {
        $subscribers = Subscriber::getFilteredList(
            $request->get('search'),
            $request->get('department_id')
        );

        return (new View())->render('subscriber.index', [
            'subscribers' => $subscribers,
            'departments' => Department::all()
        ]);
    }

    public function create(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();
            $files = $request->files();
            $errors = [];

            $validator = SubscriberValidator::make($data);
            if ($validator->fails()) {
                $errors = array_merge($errors, $validator->errors());
            }

            if (!empty($files['Photo']['name'])) {
                $imageValidator = new ImageValidator('Photo', $files['Photo'], [], 'Ошибка загрузки фото');
                if (!$imageValidator->rule()) {
                    $errors['Photo'][] = $imageValidator->validate();
                } else {
                    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/uploads/subscribers/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $ext = strtolower(pathinfo($files['Photo']['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

                    if (!in_array($ext, $allowed, true)) {
                        $errors['Photo'][] = 'Недопустимый формат файла';
                    } else {
                        $filename = 'photo_' . uniqid() . '.' . $ext;
                        $filePath = $uploadDir . $filename;

                        if (move_uploaded_file($files['Photo']['tmp_name'], $filePath)) {
                            $data['Photo'] = 'uploads/subscribers/' . $filename;
                        } else {
                            $errors['Photo'][] = 'Не удалось сохранить файл на сервере';
                        }
                    }
                }
            }

            if (!empty($errors)) {
                return (new View())->render('subscriber.create', [
                    'departments' => Department::all(),
                    'message' => json_encode($errors, JSON_UNESCAPED_UNICODE)
                ]);
            }

            Subscriber::create([
                'Surname'      => $data['Surname'],
                'Name'         => $data['Name'],
                'Patronymic'   => $data['Patronymic'] ?? null,
                'BirthdayDate' => $data['BirthdayDate'],
                'Photo'        => $data['Photo'] ?? null
            ]);

            app()->route->redirect('/sys/subscribers');
            return false;
        }

        return (new View())->render('subscriber.create', ['departments' => Department::all()]);
    }

    public function phones(Request $request): string
    {
        $subscriber = Subscriber::with('phones')->find($request->get('id'));
        return (new View())->render('subscriber.phones', [
            'subscriber' => $subscriber
        ]);
    }
}