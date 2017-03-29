<?php
class Ads_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }

    public function get_ads($page = 1, $ads_per_page = 20)
    {
        if($page <= 0)
            $page = 1;

        $offset = ($page - 1) * $ads_per_page;// Offset

        // Get the ads
        $this->db->order_by("creation_date", "desc"); 
        $query = $this->db->get('ads', $ads_per_page, $offset);
        return $query->result_array();
    }

    public function get_ad($id = 0)
    {
        $this->db->where('id', $id); 
        $query = $this->db->get('ads');
        return $query->row_array();
        //return $query->result_array();
    }

    public function set_ad()
    {
        $this->load->helper('url');

        $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'phone_image_url' => $this->input->post('phone_image_url'),
            'url' => $this->input->post('url'),
			'area' => $this->input->post('area')
        );
        return $this->db->insert('ads', $data);
    }

    public function insert_ad($data)
    {
       /* $data = array(
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'phone_image_url' => $this->input->post('phone_image_url'),
			'area' => $this->input->post('area')
        );*/
        return $this->db->insert('ads', $data);
    }

    public function insert_batch_ad($data)
    {
        log_message('debug', 'before insert_batch ' . count($data) . " entries");
        return $this->db->insert_batch('ads', $data);
    }

	public function exists($item)
	{
		$res = true;
		if(!empty($item['url']))
		{
			$this->db->where("url", $item['url']); 
			$query = $this->db->get('ads');
			$res = $query->num_rows() > 0 ? true : false;
		}
		return $res;
	}

	public function get_ads_by_search($search_terms, $alert)
	{
		foreach($search_terms as $search_term)
		{
			$this->db->like('title', $search_term);
		}
		// Look for ads that have been created after last time the alert has been sent
		$this->db->where('creation_date >', $alert['last_notification_date'] );
		$query = $this->db->get('ads');
		log_message('debug', $this->db->last_query());
		return $query->result_array();
	}

    public function delete($id)
    {
        return $this->db->delete('ads', array('id' => $id));
    }
    public function get_num_rows()
    {
        $query = $this->db->query("SELECT count(*) cnt from ads");
        $row = $query->row();
        return $row->cnt;
    }   
}