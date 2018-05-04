<?php

require __DIR__ . '/../Template.php';
require __DIR__ . '/../Database.php';
require __DIR__ . '/../User.php';

$index = new Template(__DIR__ . '/../../templates/index.tpl');
$content = new Template(__DIR__ . '/../../templates/register.tpl');
$modal = new Template(__DIR__ . '/../../templates/modal.tpl');
$modalButton = new Template(__DIR__ . '/../../templates/modal_button.tpl');

$modal->add('button', '');
$index->add('modal', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login']) && isset($_POST['password1']) && isset($_POST['password2']) && $_POST['password1'] === $_POST['password2']) {
    if (!User::userByLogin($db, $_POST['login'])) {
        $user = new User();
        $user->setLogin($_POST['login']);
        $user->setPassword($_POST['password1']);
        $user->saveUser($db);
        $modalButton->add('href', 'LoginController.php');
        $modalButton->add('title', 'Zaloguj się');
        $modal->add('message', 'Rejestracja powiodła się. Przejdź do logowania.');
        $modal->add('button', $modalButton->parse());
        $index->add('modal', $modal->parse());
    } else {
        $modal->add('message', 'Użytkownik o podanym loginie już istnieje!');
        $index->add('modal', $modal->parse());
    }
}

$index->add('script', 'register.js');
$index->add('navigation', '');
$index->add('content', $content->parse());
echo $index->parse();

