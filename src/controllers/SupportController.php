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
    $content = new Template(__DIR__ . '/../../templates/support_content.tpl');
    $conversationTemplate = Template::conversationTopicsTemplate($db, 'support');
    $myConversationTemplate = Template::conversationTopicsTemplate($db, 'support', $userID);
    $index->add('modal', '');
    $index->add('navigation', $navigation->parse());
    $content->add('conversations', $conversationTemplate);
    $content->add('openConverstaions', $myConversationTemplate);
    $index->add('content', $content->parse());
    $index->add('script', 'support.js');
    echo $index->parse();
} else {
    header('Location: LoginController.php');
}

