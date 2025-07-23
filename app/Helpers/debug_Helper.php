<?php

if (!function_exists('enable_debug_toolbar')) {
    function enable_debug_toolbar()
    {
        return \CodeIgniter\Debug\Toolbar::getInstance()->render();
    }
}
