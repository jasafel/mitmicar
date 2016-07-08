<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Mitmicar - Compartir Vehículo';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <?= $this->Html->css('tfg.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

    <?= $this->Html->script('jquery-1.12.3.min') ?>

</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-5 medium-5 columns">
            <li class="name">
                <h1><a href="<?php echo $this->Url->build(['controller'=>'Pages','action'=>'home']);?>">Mitmicar - Aplicación para compartir vehículo</a></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
            <?php if ($this->request->session()->read('Auth.User')) {?>
                <li><a href="">¡Hola, <?php echo ($this->request->session()->read('Auth.User.name'))?>!</a></li>
                <li><a href="<?php echo $this->Url->build(['controller'=>'Users','action'=>'modify']);?>">Modificar perfil</a></li>
                <li><a href="<?php echo $this->Url->build(['controller'=>'Users','action'=>'changepass']);?>">Cambiar contraseña</a></li>
                <li><a href="<?php echo $this->Url->build(['controller'=>'Users','action'=>'logout']);?>">Desconectar</a></li>
            <?php } ?>
            </ul>
        </div>
    </nav>
    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
        <nav class="top-bar expanded" data-topbar role="navigation">
            <ul class="title-area large-5 medium-5 columns">
                <li>2016 - Javier Sánchez Felipe</li>
            </ul>
        </nav>
    </footer>
</body>
</html>