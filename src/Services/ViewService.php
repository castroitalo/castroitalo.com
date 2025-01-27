<?php

declare(strict_types=1);

namespace Castroitalo\Services;

use Exception;
use League\Plates\Engine;
use Throwable;

/**
 * Abstract the League Plates usage
 *
 * @package App\Core\View
 */
class ViewService
{
    /**
     * League Plates engine
     *
     * @var null|Engine
     */
    private ?Engine $platesEngine = null;

    /**
     * Initialize View
     *
     * @return void
     */
    public function __construct(?string $templatesPath = CONF_VIEW_ROOT_DIR)
    {
        $this->platesEngine = new Engine($templatesPath);
    }

    /**
     * Render a template view
     *
     * @param string $templateFile Template file
     * @param null|array $templateData Template data to display on file
     * @return void
     * @throws Throwable
     * @throws Exception
     */
    public function renderView(string $templateFile, ?array $templateData = null): void
    {
        echo $this->platesEngine->render($templateFile, $templateData ?? []);
    }
}
