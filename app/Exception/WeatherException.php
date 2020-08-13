<?php
declare(strict_types=1);

namespace App\Exception;

use Exception;

/**
 * Exception class for handling application exceptions
 * 
 * @package    Exception
 * @author     Rupal Javiya <rupal.javiya@gmail.com>
 */
class WeatherException extends Exception
{
    public function __construct(string $message, int $code = 400)
    {
        parent::__construct($message, $code);
    }
}
