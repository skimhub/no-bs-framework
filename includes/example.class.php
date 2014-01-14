<?php

class Example extends Model {

    public $db = null;
    public $schema = array( "id"    =>  array("type" => "int",
                                              "unique" => true,
                                              "notnull" => true,
                                              "nice_name" => "Id"),

                            "title" =>  array("type" => "string",
                                              "unique" => true,
                                              "required" => true,
                                              "notnull" => true,
                                              "nice_name" => "Product title"),

                            "thumbnail" =>  array("type" => "image",
                                                  "path" => "",
                                                  "url_prefix" => "",
                                                  "width" => "150",
                                                  "height" => "150",
                                                  "nice_name" => "Thumbnail"),

                            "category_id" => array("type" => "select",
                                                   "options" => array(),
                                                   "required" => true,
                                                   "notnull" => true,
                                                   "nice_name" => "Category"),

                            "description_short" =>  array("type" => "text",
                                                          "required" => true,
                                                          "notnull" => true,
                                                          "nice_name" => "Short description"),

                            "description_long" =>  array("type" => "text",
                                                          "required" => true,
                                                          "notnull" => true,
                                                          "nice_name" => "Long description"),
                            
                            "price" =>  array("type" => "float",
                                              "required" => true,
                                              "notnull" => true,
                                              "nice_name" => "Price"),

                            "recurring" => array("type" => "select",
                                                 "nice_name" => "Recurring period",
                                                 "default" => 0,
                                                 "options" => array("1" => "1 month",
                                                                    "2" => "2 months",
                                                                    "3" => "3 months",
                                                                    "4" => "4 months",
                                                                    "5" => "5 months",
                                                                    "6" => "6 months",
                                                                    "7" => "7 months",
                                                                    "8" => "8 months",
                                                                    "9" => "9 months",
                                                                    "10" => "10 months",
                                                                    "11" => "11 months",
                                                                    "12" => "12 months"))

                            );
    public $table = "products";
    public $nice_name = "Product";

    function __construct($db){
        global $baseurl, $basepath;

        $this->db = $db;
        $this->schema['thumbnail']['path'] = $basepath."/thumbs";
        $this->schema['thumbnail']['url_prefix'] = $baseurl."/thumbs";
    }
}