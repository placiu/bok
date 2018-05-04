<?php
session_start();
require __DIR__ . '/../Template.php';
require __DIR__ . '/../Database.php';
require __DIR__ . '/../Conversation.php';
require __DIR__ . '/../Message.php';
require __DIR__ . '/../User.php';

if(isset($_SESSION['userID'])) {
    $userID = $_SESSION['userID'];
    $index = new Template(__DIR__ . '/../../templates/index.tpl');
    $navigation = new Template(__DIR__ . '/../../templates/navigation.tpl');
    $content = new Template(__DIR__ . '/../../templates/client_content.tpl');
    $conversationTemplate = Template::conversationTopicsTemplate($db, 'client', $userID);
    $index->add('modal', '');
    $index->add('navigation', $navigation->parse());
    $content->add('conversations', $conversationTemplate);
    $index->add('content', $content->parse());
    $index->add('script', 'client.js');
    echo $index->parse();
} else {
    header('Location: LoginController.php');
}


