<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_SESSION['userID'];
    $conversation = new Conversation();
    $conversation->setClientId($userID);
    $conversation->setConversation($_POST['conversationSubject']);
    $save = $conversation->saveConversation($db);
    if ($save) {
        $response = ['success' => [json_decode(json_encode($conversation), true)]];
    } else {
        $response = ['error' => 'Error'];
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    $userID = $_SESSION['userID'];
    $conversationId = isset($pathId) ? $pathId : null;
    $conversation = Conversation::conversationById($db, $conversationId);
    $conversationSupportId = $conversation->getSupportId();
    if ($conversationSupportId) {
        $move = Conversation::moveToAllConversation($db, $conversationId);
        if ($move) {
            $response = ['success' => 'moveToAllConversation'];
        } else {
            $response = ['error' => 'Error'];
        }
    } else {
        $move = Conversation::moveToMyConversation($db, $userID, $conversationId);
        if ($move) {
            $response = ['success' => 'moveToMyConversation'];
        } else {
            $response = ['error' => 'Error'];
        }
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $conversationId = isset($pathId) ? $pathId : null;
    $delete = Conversation::deleteConversation($db, $conversationId);
    if ($delete) {
        $response = ['success' => 'deleteConversation'];
    } else {
        $response = ['error' => 'Error'];
    }

} else {
    $response = ['error' => 'Wrong request method'];
}
