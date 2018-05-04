<?php

class Conversation implements JsonSerializable
{
    public $id;
    public $clientId;
    public $supportId;
    public $conversation;
    public $date;

    public function __construct()
    {
        $this->id = null;
        $this->clientId = null;
        $this->supportId = null;
        $this->conversation = '';
        $this->date = date('Y-m-d');
    }

    public function saveConversation(PDO $db)
    {
        $sql = 'INSERT INTO conversation(id, client_id, support_id, conversation, date) VALUES(null, :clientId, :supportId, :conversation, :date)';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            'clientId' => $this->clientId,
            'supportId' => $this->supportId,
            'conversation' => $this->conversation,
            'date' => $this->date
        ]);
        if ($result !== false) {
            $this->id = $db->lastInsertId();
        } else {
            return false;
        }
        return $this;
    }

    static public function moveToMyConversation(PDO $db, $userId, $conversationId)
    {
        $sql = 'UPDATE conversation SET support_id = :userId WHERE id = :conversationId';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            'userId' => $userId,
            'conversationId' => $conversationId,
        ]);
        if ($result !== false) {
            return true;
        } else {
            return false;
        }
    }

    static public function moveToAllConversation(PDO $db, $conversationId)
    {
        $sql = 'UPDATE conversation SET support_id = NULL WHERE id = :conversationId';
        $stmt = $db->prepare($sql);
        $result = $stmt->execute([
            'conversationId' => $conversationId,
        ]);
        if ($result !== false) {
            return true;
        } else {
            return false;
        }
    }

    static public function conversationByUserId(PDO $db, $userId)
    {
        $return = [];
        $stmt = $db->prepare('SELECT * FROM conversation WHERE client_id = :user_id ORDER BY id DESC');
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetchAll();
        if ($result !== false && $stmt->rowCount() > 0) {
            foreach ($result as $row) {
                $conversation = new Conversation();
                $conversation->id = $row['id'];
                $conversation->clientId = $row['client_id'];
                $conversation->supportId = $row['support_id'];
                $conversation->conversation = $row['conversation'];
                $conversation->date = $row['date'];
                $return[] = $conversation;
            }
        } else {
            return false;
        }
        return $return;
    }

    static public function conversationNotSupported(PDO $db)
    {
        $return = [];
        $stmt = $db->prepare('SELECT * FROM conversation WHERE support_id IS NULL ORDER BY id DESC');
        $stmt->execute();
        $result = $stmt->fetchAll();
        if ($result !== false && $stmt->rowCount() > 0) {
            foreach ($result as $row) {
                $conversation = new Conversation();
                $conversation->id = $row['id'];
                $conversation->clientId = $row['client_id'];
                $conversation->conversation = $row['conversation'];
                $conversation->date = $row['date'];
                $return[] = $conversation;
            }
        } else {
            return false;
        }
        return $return;
    }

    static public function conversationSupported(PDO $db, $userID)
    {
        $return = [];
        $stmt = $db->prepare('SELECT * FROM conversation WHERE support_id = :userID ORDER BY id DESC');
        $stmt->execute(['userID' => $userID]);
        $result = $stmt->fetchAll();
        if ($result !== false && $stmt->rowCount() > 0) {
            foreach ($result as $row) {
                $conversation = new Conversation();
                $conversation->id = $row['id'];
                $conversation->clientId = $row['client_id'];
                $conversation->supportId = $row['support_id'];
                $conversation->conversation = $row['conversation'];
                $conversation->date = $row['date'];
                $return[] = $conversation;
            }
        } else {
            return false;
        }
        return $return;
    }

    static public function ConversationById(PDO $db, $conversationId)
    {
        $stmt = $db->prepare('SELECT * FROM conversation WHERE id = :id');
        $result = $stmt->execute(['id' => $conversationId]);
        if ($result === true && $stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $conversation = new Conversation();
            $conversation->supportId = $row['support_id'];
        } else {
            return false;
        }
        return $conversation;
    }

    static public function deleteConversation(PDO $db, $conversationId)
    {
        $stmt = $db->prepare('DELETE FROM message WHERE conversation_id = :id');
        $result = $stmt->execute(['id' => $conversationId]);
        if ($result) {
            $stmt = $db->prepare('DELETE FROM conversation WHERE id = :id');
            $result = $stmt->execute(['id' => $conversationId]);
            if ($result) return true;
        } else {
            return false;
        }
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    public function getSupportId()
    {
        return $this->supportId;
    }

    public function setSupportId($supportId)
    {
        $this->supportId = $supportId;
    }

    public function getConversation()
    {
        return $this->conversation;
    }

    public function setConversation($conversation)
    {
        $this->conversation = $conversation;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'clientId' => $this->clientId,
            'supportId' => $this->supportId,
            'conversation' => $this->conversation,
            'date' => $this->date
        ];
    }
}