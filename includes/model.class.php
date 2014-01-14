<?php

class Model {

    function __construct(){

    }

    public function validate($params, $update_id = false){
        $errors = array();

        foreach($this->schema as $field => $rules){
            if (isset($params[$field])){
                
                if (isset($rules['notnull']) && (!$params[$field] || !trim($params[$field]))){
                    $errors[$field] = $rules['nice_name']." can not be empty";
                } 


                if (!isset($errors[$field]) && $rules['type'] == "int" && (!is_numeric($params[$field]) || (int) $params[$field] != $params[$field])) {
                    $errors[$filed] = $rules['nice_name']." must be numeric";
                } 

                if (!isset($errors[$field]) && $rules['type'] == "float" && !is_numeric($params[$field])){
                    $errors[$field] = $rules['nice_name']." must be numeric";
                } 

                if (!isset($errors[$field]) && $rules['type'] == "image" && $params[$field]){
                    if (!file_exists($rules['path']."/".$params[$field])){
                        $errors[$field] = "Invalid image uploaded";
                    }
                }

                if (!isset($errors[$field]) && $rules['type'] == "select" && !isset($rules['options'][$params[$field]]) && $params[$field] != $rules['default']){
                    $errors[$field] = "Please select a ".strtolower($rules['nice_name']);
                }

                if (!isset($errors[$field]) && isset($rules['unique']) && $rules['unique']) {
                    if ($update_id){
                        $update_id = $this->db->real_escape_string($update_id);
                        $query = "SELECT * FROM {$this->table} WHERE `{$field}` = '{$params[$field]}' AND id != '{$update_id}'";
                    } else {
                        $query = "SELECT * FROM {$this->table} WHERE `{$field}` = '{$params[$field]}'";
                    }

                    $res = $this->db->query($query) or die($this->db->error." #".__LINE__);
                    if ($res->num_rows){
                        $errors[$field] = "There is already a ".strtolower($this->nice_name)." with this ".strtolower($rules['nice_name']);
                    }
                }

            } elseif (!$update_id && isset($rules['required']) && $rules['required'] == true){
                $errors[$field] = $rules['nice_name']." is required";
            }
        }

        return $errors;
    }

    public function add($params){
        $errors = $this->validate($params);

        if (count($errors)){
            return array("status" => false, "errors" => $errors);
        } else {
            $fields = array();
            $values = array();
            foreach($params as $key => $val){
                if (isset($this->schema[$key])){
                    $fields[] = "`".$this->db->real_escape_string($key)."`";
                    $values[] = "'".$this->db->real_escape_string($val)."'";
                }
            }

            $res = $this->db->query("INSERT INTO ".$this->table."(".implode(",", $fields).") VALUES(".implode(",", $values).")") or die($this->db->error." #".__LINE__);

            return array("status" => true, "id" => $this->db->insert_id);
        }
    }

    public function update($id, $params){
        $id = $this->db->real_escape_string($id);
        $errors = $this->validate($params, $id);

        if (count($errors)){
            return array("status" => false, "errors" => $errors);
        } else {
            $criterias = array();
            foreach($params as $key => $val){
                if (isset($this->schema[$key])){
                    $criterias[] = "`".$this->db->real_escape_string($key)."`='".$this->db->real_escape_string($val)."'";
                }
            }

            if (count($criterias)){
                $res = $this->db->query("UPDATE ".$this->table." SET ".implode(",", $criterias)." WHERE id='".$id."'") or die($this->db->error." #".__LINE__);
                return array("status" => true, "id" => $id);
            } else {
                return array("status" => false);
            }
        }
    }

    public function count($params = array()){
        $criterias = array();
        foreach($params as $key => $val){
            if (isset($this->schema[$key])){
                $criterias[] = "`".$this->db->real_escape_string($key)."`='".$this->db->real_escape_string($val)."'";
            }
        }

        if (count($criterias)){
            $criteria_string = "WHERE ".implode(" AND ", $criterias);
        } else {
            $criteria_string = "";
        }

        $res = $this->db->query("SELECT count(*) as `cnt` FROM ".$this->table." ".$criteria_string) or die($this->db->error." #".__LINE__);
        if ($res->num_rows){
            $row = $res->fetch_assoc();
            return $row['cnt'];
        }

        return 0;
    }

    public function get($params = array(), $start = 0, $limit = 0, $order_field = "id", $order_direction = "DESC"){
        if ($start && $limit){
            $limit_string = "LIMIT ".$this->db->real_escape_string($start).",".$this->db->real_escape_string($limit);
        } elseif ($limit){
            $limit_string = "LIMIT ".$this->db->real_escape_string($limit);
        } else {
            $limit_string = "";
        }

        $criterias = array();
        foreach($params as $key => $val){
            if (isset($this->schema[$key])){
                $criterias[] = "`".$this->db->real_escape_string($key)."`='".$this->db->real_escape_string($val)."'";
            }
        }

        if (count($criterias)){
            $criteria_string = "WHERE ".implode(" AND ", $criterias);
        } else {
            $criteria_string = "";
        }

        $order_string = "ORDER BY `".$this->db->real_escape_string($order_field)."` ".$this->db->real_escape_string($order_direction);

        $results = array();

        $res = $this->db->query("SELECT * FROM ".$this->table." ".$criteria_string." ".$order_string." ".$limit_string) or die($this->db->error." #".__LINE__);
        if ($res->num_rows){
            if ($limit == 1){
                return $res->fetch_assoc();
            } else {
                while($row = $res->fetch_assoc()){
                    $results[$row['id']] = $row;
                }
            }
        }

        return $results;
    }

    public function delete($id){
        $id = $this->db->real_escape_string($id);

        $res = $this->db->query("DELETE FROM ".$this->table." WHERE id='".$id."'") or die($this->db->error." #".__LINE__);
    }

}