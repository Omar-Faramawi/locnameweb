<?php

class Users_Report_Model extends grocery_CRUD_Model {
    function get_list()
    {
        if($this->table_name === null)
            return false;

        //"first_name", "last_name", "email", "account_type", "country", "city_id", "created_on", "registered_from", "last_login", "number_of_locations"
        $select = "`users`.*, COALESCE(`authentications`.provider, 'LocName') AS account_type, `country`.country_name AS country, `city`.city AS city, FROM_UNIXTIME(`users`.created_on) AS creation_date, `users`.registered_from AS creation_platform, FROM_UNIXTIME(`users`.last_login) AS lastLogin, (SELECT COUNT(location.id) FROM location WHERE users.id = location.user_id) AS number_of_locations, (SELECT COUNT(friends.id) FROM friends WHERE users.id = friends.user1_id OR users.id = friends.user2_id) AS number_of_friends";

        //set_relation special queries
        if(!empty($this->relation))
        {
            foreach($this->relation as $relation)
            {
                list($field_name , $related_table , $related_field_title) = $relation;
                $unique_join_name = $this->_unique_join_name($field_name);
                $unique_field_name = $this->_unique_field_name($field_name);

                if(strstr($related_field_title,'{'))
                {
                    $related_field_title = str_replace(" ","&nbsp;",$related_field_title);
                    $select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
                }
                else
                {
                    $select .= ", $unique_join_name.$related_field_title AS $unique_field_name";
                }

                if($this->field_exists($related_field_title))
                    $select .= ", `{$this->table_name}`.$related_field_title AS '{$this->table_name}.$related_field_title'";
            }
        }

        //set_relation_n_n special queries. We prefer sub queries from a simple join for the relation_n_n as it is faster and more stable on big tables.
        if(!empty($this->relation_n_n))
        {
            $select = $this->relation_n_n_queries($select);
        }

        $this->db->select($select, false);
        $this->db->join('authentications', 'users.id = authentications.user_id', 'LEFT');
        $this->db->join('country', 'users.country = country.country_symbol', 'LEFT');
        $this->db->join('city', 'users.city_id = city.id', 'LEFT');
        //$this->db->join('location', 'users.id = location.user_id', 'LEFT');
        $this->db->group_by('`users`.id');

        $results = $this->db->get($this->table_name)->result();

        return $results;
    }
}
