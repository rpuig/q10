<?php
// app/Config/ClearSessionCache.php

namespace Config;

class ClearSessionCache
{
    public function beforeSessionStart()
    {
        $session = \Config\Services::session();
        $session->destroy();
    }
}
