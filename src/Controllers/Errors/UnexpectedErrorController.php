<?php

declare(strict_types=1);

namespace Castroitalo\Controllers\Errors;

use Castroitalo\Services\ServerService;

/**
 * Unexpected error controller
 *
 * @package Castroitalo\Controllers\Errors
 */
class UnexpectedErrorController
{
    /**
     * Shows unexpected error message
     *
     * @return void
     */
    public function unexpectedError(): void
    {
        ServerService::setApiResponse(500, 'something went wrong');
    }
}
