<?php

require('lib/autoloader.class.php');

if ($_SERVER['REQUEST_URI'] == '/')
    (new AuthController)->auth();

