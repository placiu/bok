<?php

class Template
{

    protected $template;
    protected $vars = [];

    public function __construct($file)
    {
        $this->template = $file;
    }

    public function add($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function parse()
    {
        if (!file_exists($this->template)) {
            return "Template does not exist ($this->template)";
        }
        $output = file_get_contents($this->template);

        foreach ($this->vars as $key => $value) {
            $tagToReplace = '{{' . $key . '}}';
            $output = str_replace($tagToReplace, $value, $output);
        }
        return $output;
    }

    static public function joinTemplates($templates)
    {
        $output = "";

        foreach ($templates as $template) {
            $content = (!$template instanceof Template) ? "Array element is not a Template object" : $template->parse();
            $output .= $content . "\n";
        }
        return $output;
    }

    static public function conversationTopicsTemplate($db, $role, $userID = null) {
        $conversationTemplate = '';

        if ($role == 'support' && $userID !== null) {
            $conversations = Conversation::conversationSupported($db, $userID);
        } elseif ($role == 'support' && $userID === null) {
            $conversations = Conversation::conversationNotSupported($db);
        } elseif ($role == 'client' && $userID !== null) {
            $conversations = Conversation::conversationByUserId($db, $userID);
        } else {
            $conversations = false;
        }

        if ($conversations !== false) {
            $conversationTemplate = [];
            $i = 0;
            foreach ($conversations as $conversation) {
                /**
                 * @var Conversation $conversation
                 */
                if ($role === 'client') $conversationTemplate[$i] = new Template(__DIR__ . '/../templates/client_conversation.tpl');
                if ($role === 'support') $conversationTemplate[$i] = new Template(__DIR__ . '/../templates/support_conversation.tpl');
                $conversationTemplate[$i]->add('conversationSubject', $conversation->getConversation());
                $conversationTemplate[$i]->add('conversationDate', $conversation->getDate());
                $conversationTemplate[$i]->add('conversationId', $conversation->getId());
                $i++;
            }
            $conversationTemplate = Template::joinTemplates($conversationTemplate);
            return $conversationTemplate;
        }
        return $conversationTemplate;
    }

}