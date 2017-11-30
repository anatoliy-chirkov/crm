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

        $controller = new $controller;
        $controller->$action();

    } catch (Exception $e) {

        echo "Страница не найдена";

    }
