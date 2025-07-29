<?php
namespace App\Enums;

enum HttpStatusCodes: int
{
    case OK = 200;
    case CREATED = 201;
    case ACCEPTED = 202;
    case NON_AUTHORITATIVE= 203;
    case NO_CONTENT = 204;
    case BAD_REQUEST = 400;
    case UNAUTHORIZED = 401;
    case  PAYMENT_REQUIRED = 402;
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case INTERNAL_ERROR = 500;
    // Add more as needed
    public function message(): string
    {
        return match ($this) {
            self::OK =>'The request was successful',
            self::CREATED => 'Created successfully',
            self::ACCEPTED => 'Accepted successfully',
            self::NON_AUTHORITATIVE => 'Non-Authoritative Information',
            self::NO_CONTENT => 'No Content',
            self::BAD_REQUEST => 'Bad Request',
            self::UNAUTHORIZED => 'Unauthorized',
            self::PAYMENT_REQUIRED => 'Payment Required',
            self::FORBIDDEN => 'Forbidden',
            self::NOT_FOUND => 'Not Found',
            self::INTERNAL_ERROR => 'Internal Server Error',
        };
    }
}
