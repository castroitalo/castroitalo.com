<?php

declare(strict_types=1);

namespace Castroitalo\Controllers\PublicGpgKey;

use Castroitalo\Services\ViewService;

class PublicGpgKeyController
{
    private ?ViewService $view = null;

    public function __construct()
    {
        $this->view = new ViewService();
    }

    public function publicGpgKey(): void
    {
        $this->view->renderView('/pages/public_gpg_key');
    }
}
