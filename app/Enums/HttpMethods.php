<?php

namespace App\Enums;

enum HttpMethods: string
{
    case GET    = 'GET';
    case POST   = 'POST';
    case PUT    = 'PUT';
    case DELETE = 'DELETE';
}
