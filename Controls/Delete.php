<?php namespace deadline\Controls;

use deadline\Lcs;

class Delete extends Controller
{
    /**
     *
     */
    public function delete()
    {


        if (empty(Lcs\user())) {
            header('Location:' . sprintf('%s?action=login', SITE_URL));
        }
        $message_id = empty($_GET['message_id']) ? null : (int)$_GET['message_id'];
        if (!empty($message_id)) {
            Lcs\connection()->query("DELETE FROM `messages` WHERE `id`={$message_id}");
        }
        header('Location:index.php');
    }
}












