<?php
// XXX include more precise error checking.
// needed for utility functions
include_once 'db.php';
include_once 'session.php';
include_once 'error.php';
include_once 'hash.php';

class Log {
    public function __construct() {
        // make sure the user did fill in username and pass
        $username = handleUsers();

        $db = new db;
        $db->request('SELECT id, username, mail FROM users WHERE username = :name AND password = :pass');
        $db->bind(':name', $username);
        $db->bind(':pass', Hash::get(post('password')));
        $result = $db->getAssoc();

        if (!empty($result)) {
            $_SESSION["username"] = $result['username'];
            $_SESSION["mail"] = $result['mail'];
            $_SESSION["user_id"] = $result['id'];
            Error::alliswell();
            $_SESSION['is_logged_in'] = TRUE;
            $db->request('UPDATE users SET lastconnect=now() WHERE username = :username');
            $db->bind(':username', $_SESSION["username"]);
            $db->exec();
        } else {
            Error::set("wrong username or password");
        }
    }

    public static function logout() {
        $_SESSION = array();
        session_unset();
        session_destroy();

        header("Location: index.php");
        exit();
    }
}

if (!empty($_POST)) {
    $log = new Log;
    header("Location: index.php");
}
?>
