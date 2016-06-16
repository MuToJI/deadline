<?php namespace Controls;

use deadline\Lcs;

class Save extends Controller
{
    public function save()
    {
        if (empty(Lcs\user())) {
            header('Location:' . sprintf('%s?action=login', SITE_URL));
        }
        $message_id = empty($_POST['message_id']) ? null : (int)$_POST['message_id'];
        $message = empty($_POST['message']) ? null : $_POST['message'];
        if (!empty($message) && Lcs\valid_token($_POST['token'])) {
            isset($message_id)
                ? Lcs\update_message(Lcs\connection(), $message, $message_id)
                : Lcs\insert_message(Lcs\connection(), $message, Lcs\$user['id']);
        }
        header('Location:' . sprintf('%s?action=home&message_id=%d', SITE_URL, $message_id));
    }
}


    
   

