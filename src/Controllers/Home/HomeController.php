<?php

declare(strict_types=1);

namespace Castroitalo\Controllers\Home;

use Castroitalo\Services\ViewService;

class HomeController
{
    private ?ViewService $view = null;

    public function __construct()
    {
        $this->view = new ViewService();
    }

    public function home(): void
    {
        $this->view->renderView('/pages/home');
    }
}
