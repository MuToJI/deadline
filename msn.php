<?php namespace deadline\Lcs;
use Exception;
use deadline\Controls\Controller;
/**
 * @param array $config
 * @return \PDO
 */
function connection(array $config = [])
{
    static $connection;
    if (empty($connection)) {
        $connection = new \PDO("mysql:host={$config['host']};dbname={$config['dbname']}", $config['user'], $config['password'], [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['encoding']}"
        ]);
    }
    return $connection;
}

/**
 * @param \PDO $connection
 * @param $message
 * @param $user_id
 * @param null $time
 * @return bool
 */
function insert_message(\PDO $connection, $message, $user_id, $time = null)
{
    if (empty($message)) {
        return false;
    }
    $params = [
        'message' => $message,
        'user_id' => $user_id,
    ];
    if (empty($time)) {
        $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=NOW(), `user_id`=:user_id';
    } else {
        $sql = 'INSERT INTO `messages` SET `message`=:message, `time`=:time, `user_id`=:user_id';
        $params['time'] = date('Y-m-d H:i:s', $time);
    }
    $query = $connection->prepare($sql);
    return $query->execute($params);
}

/**
 * @param \PDO $connection
 * @param $message
 * @param $message_id
 * @return bool
 */
function update_message(\PDO $connection, $message, $message_id)
{
    if (empty($message)) {
        return false;
    }
    $query = $connection->prepare('UPDATE `messages` SET `message`=:message WHERE `id`=:message_id');
    return $query->execute([
        'message' => $message,
        'message_id' => $message_id
    ]);
}

/**
 * @param \PDO $connection
 * @return mixed
 */
function pegi(\PDO $connection)
{
    if (!empty($connection)) {
        $sql = ('SELECT COUNT(`id`) FROM `messages`');
        $pg = $connection->query($sql)->fetch(\PDO::FETCH_NUM);
    }
    return ($pg[0]);
}

/**
 * @param \PDO $connection
 * @param null $message_id
 * @param $per_page
 * @return array
 */
 function load_messages(\PDO $connection, $message_id = null, $per_page)
{
    $page = !empty($_GET['p']) ? (int)$_GET['p'] : 1;
    $limit = $page * $per_page - $per_page;

    if ($message_id !== null) {
        $message_id = (int)$message_id;
    }
    return
        $message_id === null
            ? $connection->query("SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` ORDER BY m.`time` DESC LIMIT $limit, $per_page")->fetchAll()
            : $connection->query("SELECT m.`id`,m.`message`,m.`time`,u.`login` FROM `messages` m LEFT JOIN `users` u ON m.`user_id`=u.`id` WHERE m.`id`={$message_id} ORDER BY m.`time` DESC")->fetchAll();
}

/**
 * @param $token
 * @return bool
 */
function valid_token($token)
{
    return !empty($_SESSION['token']) && $token == $_SESSION['token'];
}

/**
 * @param string $name
 * @param array $vars
 * @return string
 * @throws exception
 */
function template($name, array $vars = [])
{
    if (!is_file($name)) {
        throw new exception("Could not load template file {$name}");
    }
    ob_start();
    extract($vars);
    require($name);
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
}

/**
 * @param \PDO $connection
 * @param null $login
 * @param null $password
 * @return array|bool
 */
function user(\PDO $connection = null, $login = null, $password = null)
{
    if (!empty($_SESSION['user'])) {
        return $_SESSION['user'];
    }
    if (empty($login)) {
        return null;
    }
    $query = $connection->prepare('SELECT * FROM `users` WHERE `login`=:login AND `password`=:password');
    $query->execute([
        ':login' => $login,
        ':password' => md5($password),
    ]);
    $user = $query->fetch();
    if (!empty($user)) {
        $_SESSION['user'] = $user;
    }
    return $user;
}

/**
 * @return string
 */
function token()
{
    $token = uniqid();
    $_SESSION['token'] = $token;
    return $token;
}

/**
 * @param $uri
 * @param $routes
 * @return bool
 */
function routes($uri, $routes)
{
    $request = parse_url($uri);
    $params = [];
    if (!empty($request['query'])) {
        parse_str($request['query'], $params);
    }
    $action = empty($params['action']) ? 'home' : $params['action'];
    if (isset($routes[$action])) {
        $controller = new $routes[$action]();
        return $controller->handle($action, empty($_SERVER['REQUEST_METHOD']) ? 'get' : $_SERVER['REQUEST_METHOD'], $params);
    }
    return false;
}
/**
 * @param $url
 */
function redirect($url)
{
    header("Location: {$url}");
}
