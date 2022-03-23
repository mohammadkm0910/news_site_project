<?php


namespace App\Controller;


use App\Database\SqlHelper;
use Core\Service;
use Core\Util\Redirect;
use Core\Util\View;

class Auth
{
    use View;
    use Redirect;

    public function register()
    {
        $this->view("auth.register");
    }
    public function store($request)
    {
        $username = Service::inputFilter($request['username']);
        $email = Service::inputFilter($request['email']);
        $password = Service::inputFilter($request['password']);
        if (empty($username) or empty($email) or empty($password)) {
            $this->redirectUrlBack();
        } elseif (strlen($password) < 5) {
            $this->redirectUrlBack();
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->redirectUrlBack();
        } else {
            $db = new SqlHelper();
            $user = $db->select("SELECT * FROM `users` WHERE `email` = ?; ", [$email])->fetch();
            if ($user != null) {
                $this->redirectUrlBack();
            } else {
                $request['username'] = Service::inputFilter($request['username']);
                $request['email'] = Service::inputFilter($request['email']);
                $request['password'] = password_hash(Service::inputFilter($request['password']), PASSWORD_DEFAULT);
                $db->insert("users", array_keys($request), $request);
                $db->close();
                $this->redirectUrl("login");
            }
        }
    }
    public function login()
    {
        $this->view("auth.login");
    }
    public function checkLogin($request)
    {
        $email = Service::inputFilter($request['email']);
        $password = Service::inputFilter($request['password']);
        if (empty($email) or empty($password)) {
            $_SESSION['ERROR_LOGIN'] = "ایمیل و پسورد نمی تواند خالی باشد";
            $this->redirectUrl("login");
        } else {
            $db = new SqlHelper();
            $user = $db->select("SELECT * FROM `users` WHERE `email` = ?; ", [$email])->fetch();
            if ($user != null) {
                if (password_verify($password, $user['password'])) {
                    $rememberMe = isset($request['remember-me']);
                    if ($rememberMe) {
                        setcookie("USER", $user['id'], time() + (86400 * 30));
                    } else {
                        $_SESSION['USER'] = $user['id'];
                    }
                    $_SESSION['WELCOME'] = "به سایت خوش آمدید";
                    unset($_SESSION['ERROR_LOGIN']);
                    $this->redirectUrl("home");
                } else {
                    $_SESSION['ERROR_LOGIN'] = "پسورد وارد معتبر نیست";
                    $this->redirectUrlBack();
                }
            } else {
                $_SESSION['ERROR_LOGIN'] = "چنین کاربری وجود ندارد!";
                $this->redirectUrlBack();
            }
            $db->close();
        }
    }
    public function logout()
    {
        if ((isset($_COOKIE['USER']) and trim($_COOKIE['USER']) != "")) {
            setcookie("USER", "", time() - 3600);
        } elseif ((isset($_SESSION['USER']) and trim($_SESSION['USER']) != "")) {
            unset($_SESSION['USER']);
            session_destroy();
        }
        $this->redirectUrlBack();
    }
    public function checkAdmin()
    {
        $isSessionUser = (isset($_SESSION['USER']) and trim($_SESSION['USER']) != "");
        $isCookieUser = (isset($_COOKIE['USER']) and trim($_COOKIE['USER']) != "");
        if ($isSessionUser or $isCookieUser) {
            $user = Service::loginUser();
            if ($user) {
                if ($user['permission'] != "admin") {
                    $this->redirectUrl("home");
                }
            } else {
                $this->redirectUrl("home");
            }
        } else {
            $this->redirectUrl("home");
        }
    }
}