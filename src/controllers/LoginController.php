<?php
session_start();
require __DIR__ . '/../Template.php';
require __DIR__ . '/../Database.php';
require __DIR__ . '/../User.php';

$index = new Template(__DIR__ . '/../../templates/index.tpl');
$content = new Template(__DIR__ . '/../../templates/login_form.tpl');
$modal = new Template(__DIR__ . '/../../templates/modal.tpl');

$modal->add('button', '');
$index->add('modal', '');

if (isset($_SESSION['userID'])) {
    $user = User::userById($db, $_SESSION['userID']);
    $userRole = $user->getRole();
    if ($userRole === 'client') {
        header('Location: ClientController.php');
    } elseif ($userRole === 'support') {
        header('Location: SupportController.php');
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $pass = $_POST['password'];
    $user = User::userByLogin($db, $login);
    if ($user && password_verify($pass, $user->getPassword())) {
        $_SESSION['userID'] = $user->getId();
        if ($user->getRole() === 'client') {
            header('Location: ClientController.php');
        } elseif ($user->getRole() === 'support') {
            header('Location: SupportController.php');
        }

    } else {
        $modal->add('message', 'Nieprawidłowe dane!');
        $index->add('modal', $modal->parse());
    }
}

$index->add('script', 'login.js');
$index->add('navigation', '');
$index->add('content', $content->parse());
echo $index->parse();