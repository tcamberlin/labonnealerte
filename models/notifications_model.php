<?php
class Notifications_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_notifications($max = 20) {
		if(empty($max))
			$max = 20;
        $this->db->order_by('date', 'desc'); 
        $query = $this->db->get('notifications', $max, 0);
        return $query->result_array();
    }

    public function get_notification_by_id($id) {
		$res = 0;
		if(!empty($id))
		{
	        $this->db->where('id', $id); 
	        $query = $this->db->get('notifications');
			$res   = $query->row_array();
		}
        return $res;
    }


    public function set_notification($alert_id, $number_of_ads)
    {
		$res = 0;
		if(!empty($alert_id))
		{
	        $data = array(
	            'notification_type' => 1,
	            'alert_id' => $alert_id,
				'date' => date('Y-m-d H:i:s',time()),
				'number_of_ads' => $number_of_ads
	        );
	        $res = $this->db->insert('notifications', $data);
		}
		return $res;
    }
	
	public function get_number_of_alerts_per_month($number_of_months = 12)
	{
		//if(empty($number_of_months) || $number_of_months <= 0)
		//	$number_of_months = 1
		
		$query_string = "SELECT COUNT( * ) cnt, MONTH( n.date ) AS
		month , YEAR( n.date ) AS year
		FROM `notifications` n
		WHERE n.date > DATE_SUB( DATE_SUB( curdate( ) , INTERVAL( DAY( curdate( ) ) -1 )
		DAY ) , INTERVAL 12
		MONTH )
		GROUP BY year,
		MONTH DESC";

		$query = $this->db->query($query_string);
		return $query->result_array();
	}

}