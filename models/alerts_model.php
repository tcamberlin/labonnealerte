<?php
class Alerts_model extends CI_Model {

    // TODO : Use insert_batch() function to import ads : http://localhost/labonnealerte/user_guide/database/active_record.html#insert

    public function __construct()
    {
        $this->load->database();
    }

    public function get_alerts() {
		$this->db->order_by("creation_date", "desc");
        $query = $this->db->get('alerts');
        return $query->result_array();
    }

	public function get_alerts_for_notification()
	{
        $this->db->where("active", 1);
        $query = $this->db->get('alerts');
        return $query->result_array();
	}

    public function get_alert_by_id($id) {
		$res = 0;
		if(!empty($id))
		{
	        $this->db->where('id', $id); 
	        $query = $this->db->get('alerts');
			$res   = $query->row_array();
		}
        return $res;
    }

	private function get_random_key($amount = 15)
	{
    	$keyset = "abcdefghijklmABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    	$randkey = "";
    	for ($i=0; $i<$amount; $i++)
    		$randkey .= substr($keyset, rand(0, strlen($keyset)-1), 1);
    	return $randkey;
    }

    public function set_alert($active = 0)
    {
        $this->load->helper('url');
		$this->load->helper('email');

		if(empty($active))
			$active = 0;

		$res = 0;

		if(valid_email($this->input->post('email')))
		{
	        $data = array(
	            'email' => $this->input->post('email'),
	            'search_terms' => $this->input->post('search_terms'),
				'last_notification_date' => date('Y-m-d H:i:s',time()),
				'validation_key' => $this->get_random_key(),
	            'active' => $active
	        );
	        $res = $this->db->insert('alerts', $data);
			$res = $res ? 1 : 0;
		}
		return $res;
    }

	public function set_last_notification_date($alert, $date)
	{
		$data = array('last_notification_date' => $date);
		$this->db->where('id', $alert['id']);
		return $this->db->update('alerts', $data);
	}

	public function get_alert_validation_key($id)
	{
		$alert = $this->get_alert_by_id($id);
		return empty($alert['validation_key']) ? 0 : $alert['validation_key'];
	}


	public function email_key_match($email, $key)
	{
		$this->db->where('email', $email);
		$this->db->where('validation_key', $key);
        $query = $this->db->get('alerts');
        return $query->num_rows();
	}
	
	public function activate_alerts_by_email($email)
	{
		$this->db->where('email', $email);
		$this->db->where('active', 0);  // Do not update the ones that are archived!
		$query  = $this->db->get('alerts');
		$alerts = $query->result_array();
		foreach($alerts as $alert)
		{
			$res = $this->activate_alert($alert['id']);
		}
		return $res;		
	}
	
	public function activate_alert($id)
	{
		$data = array('active' => 1);
		$this->db->where('id', $id);
		$res = $this->db->update('alerts', $data);
		if($res)
		{
			log_message('info', 'Alerte id ' . $id . ' activated successfully');
		} else {
			log_message('info', 'Alerte id ' . $id . ' could not be activated successfully');			
		}
		return $res;
	}

	public function update_alert_status($id, $value)
	{
		$data = array('active' => $value); // Archive
		$this->db->where('id', $id);
		return $this->db->update('alerts', $data);
	}

	public function is_email_validated($email)
	{
        $this->db->where('email', $email);
		$status = array(1, 2); // 1 = active, 2 = archived
		$this->db->where_in('active', $status);
        $query = $this->db->get('alerts');
		$ret   = $query->num_rows(); //$ret   = ($query->num_rows() > 0) ? true : false;
		//log_message('info', $ret . ' entries found in state 1 or 2 for email ' . $email . ' Query: ' . $this->db->last_query());
        return $ret;
	}

	public function get_num_rows()
	{
		$query = $this->db->get('alerts');
		return $query->num_rows();
	}
	
	public function get_alerts_last_year()
	{
		return array(01 => 10,
                     02 => 33,
                     03 => 33,
                     04 => 33,
                     05 => 33,
                     06 => 33,
                     07 => 33,
                     08 => 33,
                     09 => 33,
                     10 => 33,
                     11 => 33,
                     12 => 33
		);
	}
	
	
	// Returns the number of non active alerts by email
	
	public function get_not_active_alerts_by_email($email)
	{
        $this->db->where('email', $email);
        $this->db->where('active', 0); // Active
        $query = $this->db->get('alerts');
		$ret   = $query->num_rows();
        return $ret;
	}

	public function get_active_alerts_by_email($email)
	{
        $this->db->where('email', $email);
        $this->db->where('active', 0); // We need to count inactive because when email is validated, all alerts are activated.
        $this->db->or_where('active', 1);
        $query = $this->db->get('alerts');
		$ret   = $query->num_rows();
        return $ret;
	}

    public function delete($id)
    {
        return $this->db->delete('alerts', array('id' => $id));
    }
}
