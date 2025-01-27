<?php

declare(strict_types=1);

namespace Castroitalo\Controllers\Errors;

use Castroitalo\Services\ServerService;

/**
 * Page not found error controller
 *
 * @package Castroitalo\Controllers\Errors
 */
class PageNotFoundController
{
    /**
     * Shows page not found message
     *
     * @return void
     */
    public function pageNotFound(): void
    {
        ServerService::setApiResponse(404, 'PAGE NOT FOUND');
    }
}
