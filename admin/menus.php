<?php

$admin_menu = array();
$admin_menu['dashboard']        = array("menu" => "dashboard", "url" => "index.php?menu=dashboard", "title" => "Dashboard", "icon" => "fa fa-home",
                                        "submenus" => array(
                                            
                                        ));

$admin_menu['example']          = array("menu" => false, "url" => false, "title" => "Examples", "icon" => "fa fa-user",
                                        "submenus" => array(
                                            "example_form" => array("title" => "Forms example", "url" => "index.php?menu=example_form", "type" => "normal", "icon" => ""),
                                            "example_sub2" => array("title" => "Example menu #2", "url" => "index.php?menu=example_sub2", "type" => "normal", "icon" => "")
                                        ));