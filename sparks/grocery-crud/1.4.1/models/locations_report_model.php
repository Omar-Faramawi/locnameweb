<?php

class Locations_Report_Model extends grocery_CRUD_Model {
    function get_list()
    {
        if($this->table_name === null)
            return false;

        //"title", "short_code", "user_id", "country", "city", "address", "registered_from", "created_at", "hits_from_web", "hits_from_mobile", "total_hits", "last_visited"
        $select = "`location`.*, `users`.username AS owner, `location`.registered_from AS creation_platform, `location`.created_at AS creation_date, SUM(IF(location_visits.visited_from = 'W', 1, 0)) AS hits_from_web, SUM(IF(location_visits.visited_from = 'A' OR location_visits.visited_from = 'I', 1, 0)) AS hits_from_mobile, COUNT(location_visits.location_id) AS total_hits, MAX(location_visits.created_at) AS last_visited";

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
        $this->db->join('users', 'location.user_id = users.id', 'LEFT');
        $this->db->join('location_visits', 'location.id = location_visits.location_id', 'LEFT');
        $this->db->group_by('`location`.id');

        $results = $this->db->get($this->table_name)->result();

        return $results;
    }
}
