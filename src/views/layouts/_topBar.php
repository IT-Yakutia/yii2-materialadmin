<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<header>
	<nav>
        <div class="nav-wrapper">
        	<a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <a href="#" class="brand-logo truncate"><img src="<?= $adminBundle->baseUrl; ?>/img/logo.png" alt="admin icon" height="15"> <?= $this->title; ?></a>
        </div>
    </nav>
</header>