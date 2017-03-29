<?php

class Scraper extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->library('simple_html_dom');
        $this->load->model('ads_model');
		$this->load->library('uri');
    }

    public function index()
    {
		$url = 'http://www.leboncoin.fr/annonces/offres/ile_de_france/?o=';
		// $url = 'http://localhost/leboncoin/annonces.html';
		$data['ads'] = array();
		$all_ads_added = $this->run($url);
		$data['ads']   = $all_ads_added;
        $data['title'] = 'Annonces chargées dans la base';

		if( $this->input->get('mode') == 'cron')
		{
			$ret = "Hi, we are on the ". date('d/m/Y G:i:s') . " and ". count($all_ads_added) . ' ads were added to the database' . "\r\n";
			$this->output->set_output($ret);
		} else {
	        $this->load->view('templates/header', $data);
	        $this->load->view('scraper/index', $data);
	        $this->load->view('templates/footer', $data);
		}
    }

	function get_ads_from_url($url)
	{
		$aItems = array();
		$html   = file_get_html($url);
		// get news block
	    foreach($html->find('div.list-ads a') as $article)
		{
			$item['title'] = trim(iconv("ISO-8859-1", "UTF-8", $article->find('div.detail .title', 0)->plaintext));
			$item['url']   = $article->href;
			$item['area']  = 'annonces/offres/ile_de_france/';
			// TODO : In order to get the description, we need to request the page ($article->href) and get the content of ".AdviewContent .content"
			//$item['description'] = $article->find('div.detail .title', 0)->plaintext;
			$aItems[] = $item;
	    }
		// clean up memory
		$html->clear();
		unset($html);
		return $aItems;
	}

	function run()
	{
		$url = 'http://www.leboncoin.fr/annonces/offres/ile_de_france/?o=';
		
		log_message('info', 'START: Controller:' . $this->router->class . ' method:' . $this->router->method );
		
		$total_items_added = array();
		$config_trigger_key = $this->config->item('scraper_trigger_key');
		$input_trigger_key  = $this->input->get('scraper_trigger_key');
		if(!empty($input_trigger_key) && $input_trigger_key == $config_trigger_key)
		{
			//$items_added  = array();
			$count        = 0;
			$page_num     = 0;
			$max_scraped_pages = 5;
			while($page_num < $max_scraped_pages)
			{
				// Go to next page
				$page_num++;
				$items_to_add = $this->get_ads_from_url($url . $page_num);

				// Log message
				log_message('info', 'Processing page:' . $url . $page_num);
				foreach($items_to_add as $k => $item)
				{
					if($this->ads_model->exists($item))
					{
						unset($items_to_add[$k]);
						$continue = false;
						//log_message('info','Item ' . $item['url'] . ' already stored');
					}
					else
					{
						//$this->ads_model->insert_ad($item);
						//$count++;
						//$items_added[] = $item;
						$total_items_added[] = $item;
					}

				}
				// Insert ads retreived in database
				$this->ads_model->insert_batch_ad($items_to_add);
				$count += count($items_to_add);
			}
			log_message('info', $count . ' entries added to database');
			log_message('info', 'END: Controller:' . $this->router->class . ' method:' . $this->router->method );
		} else {
			log_message('info', 'Scraper run script not executed because trigger keys not matching: ' . $input_trigger_key . ' and ' . $config_trigger_key);
		}

		return $total_items_added;
	}
}

/* End of file scraper.php */
/* Location: ./application/controllers/scrapper.php */