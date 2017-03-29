<?php

class AdSearch extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ads_model');
    }

	function index()
	{
        $data['title']  = 'Effectuer une recherche';
        $data['search_results']  = array();
		
		$search_terms = explode(' ', $search_terms);
		$data['search_results']  = $this->ads_model->get_ads_by_search($search_terms, $alert);//$this->get_ads_by_search('h lecteur');

        $this->load->view('templates/header', $data);
        $this->load->view('adsearch/index', $data);
        $this->load->view('templates/footer', $data);
	}

	// Should be put inside ads controller?
	function get_ad_by_alert_id($alert_id)
	{
		return true;
	}
	
	/*function get_ads_by_search($search_terms)
	{
		$search_terms = explode(' ', $search_terms);
		foreach($search_terms as $index => $search_term)
		{
			// TODO : unset items that have length < 2
			// We also need to remove alerts that have pedophilie terms. Porn is ok ;)
			if(strlen($search_term) < 2)
			{
				unset($search_terms[$index]);
			}
		}
		return $this->ads_model->get_ads_by_search($search_terms);
	}*/

}

/* End of file adsearch.php */
/* Location: ./application/controllers/adsearch.php */