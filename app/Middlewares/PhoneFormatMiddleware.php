<?php
namespace Middlewares;

use Src\Request;
use ekhidness\PhoneUtils\PhoneFormatter;

class PhoneFormatMiddleware
{
    public function handle(Request $request): Request
    {
        $data = $request->all();

        if (!empty($data['Number'])) {
            $data['Number'] = PhoneFormatter::format($data['Number']);
            $request->set('Number', $data['Number']);
        }

        return $request;
    }
}