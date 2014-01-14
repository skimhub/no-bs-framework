<?php

class AdminHelper {

    function __construct(){

    }

    public function renderForm($object, $fields, $class, $buttons, $params = array(), $errors = array(), $extra_html = false){
        print("<form class=\"{$class}\" method=\"post\" action=\"index.php\" role=\"form\">\n");

        foreach($fields as $field_name){
            if (isset($object->schema[$field_name])){
                $rules = $object->schema[$field_name];

                $error_class = "";
                $error_message = "";
                $value = "";

                if (isset($errors[$field_name])){
                    $error_class = " has-error";
                    $error_message = "<span for=\"{$field_name}\" generated=\"true\" class=\"help-block\">{$errors[$field_name]}</span>";
                }

                if (isset($params[$field_name])){
                    $value = $params[$field_name];
                }

                if ($rules['type'] == "string"){
                    $this->renderStringField($field_name, $rules['nice_name'], $rules, $value, $error_class, $error_message);
                }

                if ($rules['type'] == "text"){
                    $this->renderTextField($field_name, $rules['nice_name'], $rules, $value, $error_class, $error_message);
                }

                if ($rules['type'] == "select"){
                    $this->renderSelectField($field_name, $rules['nice_name'], $rules, $value, $error_class, $error_message);
                }

                if ($rules['type'] == "image"){                    
                    $this->renderImageField($field_name, $rules['nice_name'], $rules, $value, $error_class, $error_message);
                }

                if ($rules['type'] == "float"){                    
                    $this->renderFloatField($field_name, $rules['nice_name'], $rules, $value, $error_class, $error_message);
                }

                if ($rules['type'] == "bool"){                    
                    $this->renderBoolField($field_name, $rules['nice_name'], $rules, $value, $error_class, $error_message);
                }
            }
        }

        if ($extra_html){
            print($extra_html);
        }

        $this->renderButtons($buttons);

        print("</form>\n");
    }

    public function renderCustomField($label, $html, $print = true){
        $output = " <div class=\"form-group\">
                        <label class=\"col-sm-2 control-label\">{$label}</label>
                        <div class=\"col-sm-10\">
                            {$html}
                        </div>
                    </div>\n";

        if ($print){
            print($output);
        }

        return $output;
    }

    public function renderButtons($buttons){
        print(" <div class=\"form-group\">
                    <label class=\"col-sm-2 control-label\">&nbsp;</label>
                    <div class=\"col-sm-10\">
                        {$buttons}
                    </div>
                </div>\n");
    }

    public function renderBoolField($field_name, $title, $rules, $value, $error_class, $error_message){

        if ($value){
            $value = " checked=\"checked\"";
        }

        print(" <div class=\"form-group{$error_class}\">
                    <label class=\"col-sm-2 control-label\">{$title}</label>
                    <div class=\"col-sm-2\">
                        <input type=\"checkbox\"  name=\"{$field_name}\" placeholder=\"\"{$value} />
                        {$error_message}
                    </div>
                </div>\n");
    }

    public function renderFloatField($field_name, $title, $rules, $value, $error_class, $error_message){

        print(" <div class=\"form-group{$error_class}\">
                    <label class=\"col-sm-2 control-label\">{$title}</label>
                    <div class=\"col-sm-2\">
                        <input type=\"text\" class=\"form-control\" name=\"{$field_name}\" placeholder=\"\" value=\"{$value}\" />
                        {$error_message}
                    </div>
                </div>\n");
    }

    public function renderImageField($field_name, $title, $rules, $value, $error_class, $error_message){
        if ($value){
            $image_url = $rules['url_prefix']."/".$value;
        } else {
            $image_url = "http://placehold.it/{$rules['width']}x{$rules['height']}&text=Click+to+upload";
        }

        print(" <div class=\"form-group{$error_class}\">
                    <label class=\"col-sm-2 control-label\">{$title}</label>
                    <div class=\"col-sm-10\">
                        <img src=\"{$image_url}\" 
                             class=\"img-thumbnail\" 
                             style=\"cursor:pointer; max-width: {$rules['width']}px; max-height: {$rules['height']}px; \" 
                             id=\"upload_{$field_name}\" />

                        <input type=\"hidden\" name=\"{$field_name}\" value=\"{$value}\" id=\"{$field_name}\" />
                        {$error_message}
                    </div>
                </div>
                <script>
                    jQuery(document).ready(function(){
                        ajaxUpload('{$field_name}', '{$rules['path']}', '{$rules['url_prefix']}');
                    });
                </script>\n");
    }

    public function renderSelectField($field_name, $title, $rules, $value, $error_class, $error_message){

        print(" <div class=\"form-group{$error_class}\">
                    <label class=\"col-sm-2 control-label\">{$title}</label>
                    <div class=\"col-sm-4\">
                        <select name=\"{$field_name}\" class=\"form-control col-sm-4\">
                            <option value=\"0\">Select ".strtolower($title)."</option>\n");

        foreach($rules['options'] as $key => $val){
            print("<option value=\"{$key}\"");
            if ($key == $value){
                print(" selected=\"selected\"");
            }
            print(">{$val}</option>\n");
        }

        print("         </select>
                        {$error_message}
                    </div>
                </div>\n");
    }

    public function renderStringField($field_name, $title, $rules, $value, $error_class, $error_message){

        print(" <div class=\"form-group{$error_class}\">
                    <label class=\"col-sm-2 control-label\">{$title}</label>
                    <div class=\"col-sm-10\">
                        <input type=\"text\" class=\"form-control\" name=\"{$field_name}\" placeholder=\"\" value=\"{$value}\" />
                        {$error_message}
                    </div>
                </div>\n");
    }

    public function renderTextField($field_name, $title, $rules, $value, $error_class, $error_message){

        print(" <div class=\"form-group{$error_class}\">
                    <label class=\"col-sm-2 control-label\">{$title}</label>
                    <div class=\"col-sm-10\">
                        <textarea class=\"form-control\" name=\"{$field_name}\" placeholder=\"\" rows=\"4\" />{$value}</textarea>
                        {$error_message}
                    </div>
                </div>\n");
    }

    public function success($message){
        print(" <div class=\"alert alert-success alert-dismissable\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                    {$message}
                </div>\n");
    }

    public function error($message){
        print(" <div class=\"alert alert-danger alert-dismissable\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>
                    {$message}
                </div>\n");
    }

    public function renderMenu($admin_menu, $menu){

        // rendering the menu
        foreach($admin_menu as $main_menu => $main_menu_data){
            $menu_items = array();
            $menu_plugins = array();
            $plugin_items = array();
            
            $menu_items[] = $main_menu;
            
            if (count($main_menu_data['submenus'])){
                foreach($main_menu_data['submenus'] as $sub_menu => $sub_menu_data){
                    $menu_items[] = $sub_menu;
                    if (isset($sub_menu_data['submenus'])){
                        foreach($sub_menu_data['submenus'] as $level2_menu_key => $level2_menu_data){
                            $menu_items[] = $level2_menu_key;
                        }
                    }
                }
            }
                                                
            if (isset($menu) && (in_array($menu, $menu_items) || (isset($main_menu_data['triggers']) && in_array($menu, $main_menu_data['triggers'])))){
                $in = " in";
                $active = " active";
            } else {
                $in = "";
                $active = "";
            }
            
            if ($main_menu_data['url']){
                $main_target = $main_menu_data['url'];
                $main_target_hash = $main_target;
                $clickable = " clickable";
                $toggle = "";
            } else {                                    
                $main_target = "collapse-".$main_menu;
                $main_target_hash = "#".$main_target;
                $clickable = "";
                $toggle = " data-toggle=\"collapse\"";
            }
    
    
            print(" <li class=\"accordion-group{$active}\">");

            if (count($main_menu_data['submenus'])){
                print(" <a data-toggle=\"collapse\" data-parent=\"#nav-mainmenu\" href=\"{$main_target_hash}\">
                            <span class=\"{$main_menu_data['icon']} nav-fixed-icon\"></span>
                            <span class=\"text\">{$main_menu_data['title']}</span>
                            <span class=\"fa fa-chevron-down pull-right side-nav-icon \"></span>
                        </a>");
            } else {
                print(" <a data-parent=\"#nav-mainmenu\" href=\"{$main_target_hash}\">
                            <span class=\"{$main_menu_data['icon']} nav-fixed-icon\"></span>
                            <span class=\"text\">{$main_menu_data['title']}</span>
                        </a>");
            }
            
    
            if (count($main_menu_data['submenus'])){
    
                print("<ul class=\"nav-submenu collapse{$in}\" id=\"{$main_target}\">");
            
                foreach($main_menu_data['submenus'] as $sub_menu => $sub_menu_data){
                    if ($sub_menu_data['type'] == "normal"){
                        
                        $level2_sub_menu_keys = array();
                        
                        if (isset($sub_menu_data['submenus']) && count($sub_menu_data['submenus'])){
                            $has_submenus = true;
                            foreach($sub_menu_data['submenus'] as $level2_sub_menu_key => $level2_sub_menu_data){
                                $level2_sub_menu_keys[] = $level2_sub_menu_key;
                            }
                        } else {
                            $has_submenus = false;
                        }
                        
                        if ($has_submenus){
                            $active = " class=\"accordion-group\"";
                        } elseif (isset($menu) && $menu == $sub_menu ){
                            $active = " class=\"active\"";  
                        } else {
                            $active = "";
                        }
                        
                        print("<li{$active}>");
                        
                        if ($has_submenus){
                            $href = "#test";
                            $data = " data-toggle=\"collapse\" data-parent=\"#{$main_target}\"";
                            $caret = " <span class=\"caret pull-right\"></span>";
                        } else {
                            $href = $sub_menu_data['url'];
                            $data = "";
                            $caret = "";
                        }
                        
                        print("<a href=\"{$href}\"{$data}");
                        if ($sub_menu == $menu || in_array($menu, $level2_sub_menu_keys)){
                            print(" class=\"active\"");
                        }
                        print(">");
                        
                        if (isset($sub_menu_data['icon']) && $sub_menu_data['icon']){
                            print("<span class=\"{$sub_menu_data['icon']} nav-fixed-icon\"></span>"); 
                        }
                        print("{$sub_menu_data['title']}{$caret}</a>");
                        
                        if (isset($sub_menu_data['submenus']) && count($sub_menu_data['submenus'])){
                            
                            if (isset($menu) && in_array($menu, $level2_sub_menu_keys)){
                                $level2_in = " in"; 
                            } else {
                                $level2_in = "";    
                            }
                            
                            print("<ul class=\"nav-subitem collapse{$level2_in}\" id=\"test\">");
                            
                            foreach($sub_menu_data['submenus'] as $level2_sub_menu_key => $level2_sub_menu_data){
                                if (isset($menu) && $level2_sub_menu_key == $menu){
                                    $level2_active = " class=\"active\"";   
                                } else {
                                    $level2_active = "";    
                                }
                                print("<li><a href=\"{$level2_sub_menu_data['url']}\"{$level2_active}>{$level2_sub_menu_data['title']}</a></li>");  
                            }
                            
                            print("</ul>");
                        }
                        
                        print("</li>");
                        
                    }
                }
                if (isset($main_menu_data['tips']) && count($main_menu_data['tips'])){
                    print(" <div class=\"pro-tips\">
                                <strong>Tip: </strong> {$main_menu_data['tips'][rand(0, count($main_menu_data['tips'])-1)]}
                            </div>");
                }

                print("</ul>");
            }
            
            print("</li>");
        }
    }
}