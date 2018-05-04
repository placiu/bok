<?php

class Message implements JsonSerializable
{
    public $id;
    public $conversationId;
    public $senderId;
    public $senderLogin;
    public $message;
    public $datetime;

    public function __construct()
    {
        $this->id = null;
        $this->conversationId = null;
        $this->senderId = null;
        $this->senderLogin = '';
        $this->message = '';
        $this->datetime = date('Y-m-d H:i:s');
    }

    public function saveMessage(PDO $db)
    {
        $sql = 'INSERT INTO message(id, conversation_id, sender_id, message, datetime) VALUES(null, :conversationId, :senderId, :message, :datetime)';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            'conversationId' => $this->conversationId,
            'senderId' => $this->senderId,
            'message' => $this->message,
            'datetime' => $this->datetime
        ]);
        if ($result) {
            $this->id = $db->lastInsertId();
            return $this;
        }
        return false;
    }

    static public function messagesByConversationId(PDO $db, $conversationId)
    {
        $return = [];
        $stmt = $db->prepare('SELECT * FROM message JOIN users ON message.sender_id = users.id WHERE conversation_id = :conversationId ORDER BY datetime');
        $stmt->execute(['conversationId' => $conversationId]);
        $result = $stmt->fetchAll();
        if ($result && $stmt->rowCount() > 0) {
            foreach ($result as $row) {
                $messages = new Message();
                $messages->id = $row['id'];
                $messages->conversationId = $row['conversation_id'];
                $messages->senderId = $row['sender_id'];
                $messages->senderLogin = $row['login'];
                $messages->message = $row['message'];
                $messages->datetime = $row['datetime'];
                $return[] = $messages;
            }
            return $return;
        }
        return false;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getConversationId()
    {
        return $this->conversationId;
    }

    public function setConversationId($conversationId)
    {
        $this->conversationId = $conversationId;
    }

    public function getSenderId()
    {
        return $this->senderId;
    }

    public function setSenderId($senderId)
    {
        $this->senderId = $senderId;
    }

    public function getSenderLogin()
    {
        return $this->senderLogin;
    }

    public function setSenderLogin($senderLogin)
    {
        $this->senderLogin = $senderLogin;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'conversationId' => $this->conversationId,
            'senderId' => $this->senderId,
            'senderLogin' => $this->senderLogin,
            'message' => $this->message,
            'datetime' => $this->datetime
        ];
    }

}