<?php

use Castroitalo\Services\ServerService;

$this->layout('/layouts/base');

?>

<?php $this->start('styles'); ?>
<link rel="stylesheet" href="<?= ServerService::getUrl('/static/styles/pages/home.css'); ?>">
<?php $this->end(); ?>

<div class="container d-flex flex-column align-items-center min-vh-100 justify-content-center" id="home-container">
    <h1 id="home-title" class="mb-4">Castroitalo.com</h1>

    <ul class="list-unstyled d-flex" id="site-options">
        <li class="me-2 site-option"><a href="<?= CONF_ROUTES_GPG_KEY; ?>">Public GPG key</a></li>
    </ul>
</div>