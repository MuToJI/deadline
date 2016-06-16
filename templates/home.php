<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>epic blog</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
<a href="<?= $site_url ?>"><h1>Epic blog</h1></a>
<?php if (!empty($messages)): ?>
    <?php foreach ($messages as $message): ?>
        <div  id="ram" , class="message">
            <a href="<?= $site_url ?>?action=home&message_id=<?= $message['id'] ?>"><h2>message № <?= $message['id'] ?></h2></a>
            <div id="ran"><?= htmlspecialchars($message['message']); ?></div>
            <span class="left"><?= $message['login']; ?></span>
            <span class="right"><?= $message['time']; ?></span>
            </div>
        <br/>
    <?php endforeach ?>
    <?php if(!empty($pages)) : ?>
     <?php   for ($page = 1; $page <= $pages; $page++){
        echo '<a href="index.php?p='.$page.'">'.$page. '</a> ';} ?>
    <?php endif ?>
<?php endif ?>
<form action="<?= $site_url ?>?action=save" method="post">
    <textarea name="message" id="message" rows="10"><?= empty($message_id) ? '' : $messages[0]['message'] ?></textarea>
    <input type="hidden" name="message_id" value="<?= $message_id ?>">
    <input type="submit" name="action" value="Сохранить">
    <input type="hidden" name="token" value="<?= $token ?>">
</form>
</body>
</html>
        <?php if (!empty($message_id)): ?>
        <div class="message">
           <br><a href="http://endline/index.php?action=delete&message_id=<?= $message['id'] ?>"><input type="submit" name="action"  value="Удалить"></a></br>
        </div>
        <?php endif ?>
