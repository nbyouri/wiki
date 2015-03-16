<?php
	/* Start the session, this needs to be loaded everytime */
	session_start();
	
	$gid = getGid();
	$_SESSION['gid'] = $gid;

	function incCount() {
		if (!isset($_SESSION['count']))
			$_SESSION['count'] = 0;
		else
			$_SESSION['count']++;
	}

	function showCount() {
		if (isset($_SESSION['count']))
			echo 'count = ' . $_SESSION['count'];
	}

	function resetCount() {
		if (isset($_SESSION['count']))
			$_SESSION['count'] = 0;
	}

	function showSession() {
		echo '<pre>';
		print_r($_SESSION);
		echo '</pre>';
	}

	function isPost($field) {
		return (isset($_POST[$field]) && !empty($_POST[$field]));
	}

	function isGet($field) {
		return (isset($_GET[$field]) && !empty($_GET[$field]));
	}

	function post($field) {
		return $_POST[$field];
	}

	function get($field) {
		return $_GET[$field];
	}

	function getSession($field) {
		return $_SESSION[$field];
	}

	function handleUsers() {
		if (isPost('username')) {
			if (isPost('password'))
				return 'USER '. $_POST['username'] . ' just logged in';
			else
				return 'no password set';
		} else {
			return 'no info';
		}
	}

	function getGid() {
		/* the user id can be 0 so don't use isGet() */
		if (isset($_GET['gid']))
			return get('gid');
	}

	/* return human readable permission based on user id */
	function getPerm() {
		switch (getGid()) {
			case -1 : 
				return 'failed to get user id';
				break;
			case 0 : /* god */
				return 'root';
				break;
			case 1 :
				return 'admin';
				break;
			case 2 :
				return 'mod';
				break;
			case 3 : 
				return 'user';
				break;
			case 4 : /* non activated user */
				return 'registered';
				break;
			default:
				return 'invalid user id';
		}
	}

	/* catch post */
	if (isPost('submit')) {
		resetCount();
		header("Location: index.php");
	}
?>
