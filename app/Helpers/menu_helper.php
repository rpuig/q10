<?php

function render_menu_left($isLoggedIn) {
    $menuConfig = new \Config\Menu_Top();

    $html = '';
    foreach ($menuConfig->items as $item) {

        if (isset($item['condition']) && $item['title'] === 'Profile' && $isLoggedIn) {
            $html .= "<li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                " . lang('App.menu_profile') . "
                </a>
                <div class='dropdown-menu'>";

            // Adding Profile link
            $html .= "<a class='dropdown-item' href='" . base_url($item['link']) . "'>" . lang('App.menu_editProfile') . "</a>";

            foreach ($menuConfig->items as $subItem) {
                if (isset($subItem['condition']) && $subItem['title'] === 'AstroProfile' && $isLoggedIn) {
                    $html .= "<a class='dropdown-item' href='" . base_url($subItem['link']) . "'>" . lang('App.menu_astroProfile') . "</a>";
                }
                if (isset($subItem['condition']) && $subItem['title'] === 'Settings' && $isLoggedIn) {
                    $html .= "<a class='dropdown-item' href='" . base_url($subItem['link']) . "'>" . lang('App.menu_settings') . "</a>";
                }
                if (isset($subItem['condition']) && $subItem['title'] === 'publicProfile' && $isLoggedIn) {
                    $html .= "<a class='dropdown-item' href='" . base_url($subItem['link']) . "'>" . lang('App.menu_publicProfile') . "</a>";
                }
            }
            $html .= "</div></li>";
        } elseif (isset($item['condition']) && $item['title'] === 'Matches' && $isLoggedIn) {
            $html .= "<li class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                " . lang('App.menu_matches') . "
                </a>
                <div class='dropdown-menu'>
                    <a class='dropdown-item' href='" . base_url('/matches') . "'>" . lang('App.menu_current') . "</a>
                    <a class='dropdown-item' href='" . base_url('/conversations') . "'>" . lang('App.menu_conversations') . "</a>
                </div>
            </li>";
        } 
        
            elseif (!isset($item['condition']) && $item['title'] !== 'Logout') {
           
           
            $html .= "<li class='nav-item me-3'><a class='nav-link' href='" . base_url($item['link']) . "'>" . lang('App.' ."menu_". strtolower($item['title'])) . "</a></li>";
        }
    }

    return $html;
}

function render_menu_right($isLoggedIn) {
    $menuConfig = new \Config\Menu_Top();

    $html = '';
    foreach ($menuConfig->items as $item) {
        if (isset($item['condition']) && $item['title'] === 'Login' && !$isLoggedIn) {
            $html .= "<li class='nav-item me-3'><a class='nav-link' href='" . base_url($item['link']) . "'>" . lang('App.menu_login') . "</a></li>";
        } 
        
        elseif (isset($item['condition']) && $item['title'] === 'Logout' && $isLoggedIn) {
            $html .= "<li class='nav-item me-3'><a class='nav-link' href='" . base_url($item['link']) . "'>" . lang('App.menu_logout') . "</a></li>";
        } 

      
        
        elseif (isset($item['condition']) && $item['title'] === 'Register' && !$isLoggedIn) {
            $html .= "<li class='nav-item me-3'><a class='nav-link' href='" . base_url($item['link']) . "'>" . lang('App.menu_register') . "</a></li>";
        } 
        
        elseif (isset($item['condition']) && $item['title'] === 'publicProfile' && $isLoggedIn && str_ends_with(site_url('publicProfile'), $item['condition2'])) {
            $html .= "<li class='nav-item me-3'><a class='nav-link' href='javascript:history.back()'>" . lang('App.menu_back') . "</a></li>";
        }
    }

    return $html;
}
