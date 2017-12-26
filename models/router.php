<?php

    try {

        $controller = 'AuthController';
        $action = 'index';

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if (!empty($routes[1])) {
            $controller = ucfirst($routes[1])."Controller";
        }

        if (!empty($routes[2])) {
            $action = $routes[2];

            $params = explode('?', $action);
            $action = $params[0];
        }

        if ($routes[1] == 'api') {
            $controller = ucfirst($routes[2])."Controller";
            $controller = "Api".$controller;

            if (!empty($routes[3])) {
                $action = $routes[3];
            }
        }

        if ($routes[1] == 'api' && $routes[2] == null) {
            $controller = 'ApiCallbackController';
            $action = 'index';
        }

        if (isset($controller) && isset($action)) {
            $controller = new $controller;
            $controller->$action();
        } else {
            echo "Страница не найдена";
        }

    } catch (Exception $e) {

        echo "Страница не найдена";

    }
