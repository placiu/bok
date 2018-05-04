<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $messages = Message::messagesByConversationId($db, isset($pathId) ? $pathId : null);
    if ($messages) {
        $messagesArr = [];
        foreach ($messages as $message) {
            $messagesArr[] = json_decode(json_encode($message), true);
        }
        $response = ['success' => $messagesArr];
    } else {
        $response = ['error' => 'Error'];
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../User.php';
    $user = User::userById($db, $_SESSION['userID']);
    $userLogin = $user->getLogin();
    $message = new Message();
    $message->setConversationId($_POST['id']);
    $message->setSenderId($_SESSION['userID']);
    $message->setSenderLogin($userLogin);
    $message->setMessage($_POST['message']);
    $save = $message->saveMessage($db);
    if ($save) {
        $response = ['success' => [json_decode(json_encode($message), true)]];
    } else {
        $response = ['error' => 'Error'];
    }
} else {
    $response = ['error' => 'Wrong request method'];
}