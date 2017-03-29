<?php
class Statistics extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('alerts_model');
		$this->load->model('ads_model');
		$this->load->model('notifications_model');
    }

	public function index()
	{
        $data['title']  = 'Liste des alertes';

		$data['total_number_of_alerts'] = $this->get_total_number_of_alert();
		
		$data['number_of_alerts_per_month'] = $this->get_number_of_alerts_per_month();
		
		$data['notifications'] = $this->notifications_model->get_notifications();
        //$data['insert_result'] = 42;
        $this->load->view('templates/header', $data);
        $this->load->view('pages/statistics', $data);
        $this->load->view('templates/footer', $data);
	}

	public function get_total_number_of_alert()
	{
		return $this->alerts_model->get_num_rows();
	}
	
	public function get_alerts_last_year()
	{
		return $this->alerts_model->get_alerts_last_year();
	}
	
	public function get_number_of_alerts_per_month($number_of_months = 12)
	{
		if(empty($number_of_months))
			$number_of_months = 12;
		return $this->notifications_model->get_number_of_alerts_per_month($number_of_months);
	}

	public function notifications_year()
	{
		$data = '{
		"cols": [
		{"id":"","label":"year","type":"string"},
		{"id":"","label":"sales","type":"number"},
		{"id":"","label":"expenses","type":"number"}
		],
		"rows": [
		{"c":[{"v":"2001"},{"v":3},{"v":5}]},
		{"c":[{"v":"2002"},{"v":5},{"v":10}]},
		{"c":[{"v":"2003"},{"v":6},{"v":4}]},
		{"c":[{"v":"2004"},{"v":8},{"v":32}]},
		{"c":[{"v":"2005"},{"v":3},{"v":56}]}
		]
		}';
		
		$notifications = $this->notifications_model->get_number_of_notifications_per_month();
		
		foreach($notifications as $index => $values)
		{
			if($values['year'] == '2012') // date('yyyy')
			{
				switch ($values['month']) {
				    case '1':
				        echo "i égal 0";
				        break;
				    case '2':
				        break;
				    case '3':
				        break;
				}
			}
		}
				
		$my_data = array(
			'cols' => array(array('id' => '', 'label' => 'Months', 'type' => 'string'),
			                array('id' => '', 'label' => 'Slices', 'type' => 'number')),
			'rows' => array(array('c' => array(array('v' => 'Janvier'), array('v' => 10))),
			                array('c' => array(array('v' => 'Février'), array('v' => 50))),
			                array('c' => array(array('v' => 'Mars'), array('v' => 150))),
			                array('c' => array(array('v' => 'Avril'), array('v' => 300))),
			                array('c' => array(array('v' => 'Mai'), array('v' => 600))),
			                array('c' => array(array('v' => 'Juin'), array('v' => 800))),
			                array('c' => array(array('v' => 'Juillet'), array('v' => 1000))),
			                array('c' => array(array('v' => 'Août'), array('v' => 1200))),
			                array('c' => array(array('v' => 'Septembre'), array('v' => 1300))),
			                array('c' => array(array('v' => 'Octobre'), array('v' => 1600))),
			                array('c' => array(array('v' => 'Novembre'), array('v' => 2000))),
                			array('c' => array(array('v' => 'Décembre'), array('v' => 2500)))
			)
		);
		$this->output
		    ->set_content_type('application/json')
		    ->set_output(json_encode($my_data));
		    //->set_output(json_encode(array(array('Mushrooms', 3), array('Onions', 1), array('Olives', 1), array('Zucchini', 1), array('Pepperoni', 2))));
		
		
/*			{
			"cols": [{"id":"","label":"year","type":"string"},
			         {"id":"","label":"sales","type":"number"},
			         {"id":"","label":"expenses","type":"number"}],
			"rows": [{"c":[{"v":"2001"},{"v":3},{"v":5}]},
			         {"c":[{"v":"2002"},{"v":5},{"v":10}]},
			         {"c":[{"v":"2003"},{"v":6},{"v":4}]},
			         {"c":[{"v":"2004"},{"v":8},{"v":32}]},
			         {"c":[{"v":"2005"},{"v":3},{"v":56}]}]
			}
			
{
"cols":[{"id":"","label":"Toppings","type":"string"},
        {"id":"","label":"Slices","type":"number"}],
"rows": [{"c":[{"v":"2001"},{"v":"3"}]},
         {"c":[{"v":"2002"},{"v":"5"}]},
         {"c":[{"v":"2003"},{"v":"6"}]},
         {"c":[{"v":"2004"},{"v":"8"}]},
         {"c":[{"v":"2005"},{"v":"3"}]}]
}


*/
			//$this->output->set_output($data);
	}

}