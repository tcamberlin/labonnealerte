<?php
class Ads extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('ads_model');
    }

    public function index()
    {
        $ads_per_page = 20;
        // Retreive data from URL
        $default = array('page');
        $vars    = $this->uri->uri_to_assoc(3, $default);

        if(empty($vars['page']))
            $vars['page'] = 1;

        // Get number of rows
        $num_rows = $this->ads_model->get_num_rows();

        // Set correct page number
        $number_of_pages = floor($num_rows / $ads_per_page);
        if($vars['page'] > $number_of_pages) {
            $vars['page'] = 1;
        }
        $data['pagination'] = $this->pagination($vars['page'], $number_of_pages);

        $data['ads']   = $this->ads_model->get_ads($vars['page'], $ads_per_page);
        $data['title'] = 'Liste des annonces';

        $this->load->view('templates/header', $data);
        $this->load->view('ads/index', $data);
        $this->load->view('templates/footer', $data);
    }

    public function single()
    {
        // Retreive data from URL
        $default = array('id');
        $vars    = $this->uri->uri_to_assoc(3, $default);

        $data['id']  = $vars['id'];

        $data['ad'] = $this->ads_model->get_ad($vars['id']);
        $data['title']  = "Annonce trouvée pour vous par La bonne alerte";

        $this->load->view('templates/header', $data);
        $this->load->view('ads/single', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title']  = "Création d'une annonce";
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('area', 'Area', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('ads/create', $data);
            $this->load->view('templates/footer', $data);
            
        }
        else
        {
            $this->ads_model->set_ad();
            $this->load->view('templates/header', $data);
            $this->load->view('ads/success', $data);
            $this->load->view('templates/footer', $data);
        }

    }

    public function delete($id)
    {
        $data['title']  = "Suppression de l'annonce";

        if(!empty($id))
        {
            $data['res'] = $this->ads_model->delete($id);
            $data['id'] = $id;
            $this->load->view('templates/header', $data);
            $this->load->view('ads/delete', $data);
            $this->load->view('templates/footer', $data);
        }
        
    }

    // This function prints pagination links
    public function pagination($page, $number_of_pages)
    {
        $res = array();

        // Display previous link
        if($page >= 5) {
            $previous_page = $page - 1;
            $res[] = array('type' => 'previous', 'page_number' => $previous_page);
        }

        // Compute start page
        if($page - 4 >= 0) {
            $start_page = $page - 4;
        } else {
            $start_page = 1;
        }

        // Compute end page
        $end_page = min($number_of_pages, ($start_page + 9));

        $index = $start_page;
        while($index <= $end_page) {
            $res[] = array('type' => 'standard', 'page_number' => $index);
            $index++;
        }

        // Display next link
        if($number_of_pages > (20 * $page) ) {
            $next_page = $page + 1;
            $res[] = array('type' => 'next', 'page_number' => $next_page);
        }
        return $res;
    }

}