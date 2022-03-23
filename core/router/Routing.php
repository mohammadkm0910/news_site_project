<?php

namespace Core\Router;

use Core\Service;

class Routing
{
    private $currentRoute;
    private $methodField;
    private $routes;
    private $values = [];

    public function __construct()
    {
        $slice = $GLOBALS['isDomain'] ? 0 : 1;
        $this->currentRoute = array_slice(explode('/', strtolower(CURRENT_ROUTE)), $slice);
        $this->methodField = strtolower(Service::getMethodField());
        $this->routes = $GLOBALS['routes'];
    }
    public function run()
    {
        $match = $this->match();
        if (empty($match)) $this->error404();
        $className = $match['class'];
        $method = $match['method'];
        $path = fix_path(BASE_PATH."/app/controller/$className.php");
        if (!file_exists($path)) $this->error404();
        $class = "\App\Controller\\".$className;
        $object = new $class();
        if (method_exists($object, $match['method'])) {
            if (sizeof($this->values) > 0) {
                if ($this->methodField == "post") {
                    $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
                    call_user_func_array(array($object, $method), array_merge([$request], $this->values));
                } else {
                    call_user_func_array(array($object, $method), $this->values);
                }
            } else {
                if ($this->methodField == "post") {
                    $request = isset($_FILES) ? array_merge($_POST, $_FILES) : $_POST;
                    $object->$method($request);
                } else {
                    $object->$method();
                }
            }
        } else {
            $this->error404();
        }
    }
    private function match() {
        $reservedRoutes = $this->routes[$this->methodField];
        foreach ($reservedRoutes as $reservedRoute) {
            if ($this->compare($reservedRoute['url'])) {
                return ['class' => $reservedRoute['class'], 'method' => $reservedRoute['method']];
            } else {
                $this->values = [];
            }
        }
        return [];
    }
    private function compare($reservedUrl)
    {
        if (trim($reservedUrl, '/') === '') {
            return trim($this->currentRoute[0], '/') === '';
        }
        $reservedUrlList = explode('/', $reservedUrl);
        if (sizeof($this->currentRoute) != sizeof($reservedUrlList)) {
            return false;
        }
        foreach ($this->currentRoute as $key => $currentRouteElement) {
            $reservedUrlElement = $reservedUrlList[$key];
            if (substr($reservedUrlElement, 0, 1) == '{' and substr($reservedUrlElement, -1) == '}') {
                $this->values[] = $currentRouteElement;
            } elseif ($reservedUrlElement != $currentRouteElement) {
                return false;
            }
        }
        return true;
    }
    private function error404()
    {
        http_response_code(404);
        require_once fix_path(BASE_PATH . "/app/view/error/error404.php");
        exit;
    }
}