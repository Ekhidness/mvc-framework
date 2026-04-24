<?php
namespace Validators;

use Src\Validator\AbstractValidator;

class ImageValidator extends AbstractValidator
{
    protected string $message = 'Файл :field должен быть изображением';

    public function rule(): bool
    {
        if (empty($this->value) || !is_array($this->value)) {
            return true;
        }

        if ($this->value['error'] !== UPLOAD_ERR_OK) {
            $this->message = 'Ошибка загрузки файла :field';
            return false;
        }

        if (!is_uploaded_file($this->value['tmp_name'])) {
            $this->message = 'Файл :field не был загружен';
            return false;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $this->value['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mimeType, $allowedTypes)) {
            $this->message = 'Файл :field имеет недопустимый тип';
            return false;
        }

        $maxSize = 5 * 1024 * 1024;
        if ($this->value['size'] > $maxSize) {
            $this->message = 'Размер файла :field превышает 5 МБ';
            return false;
        }

        return true;
    }
}