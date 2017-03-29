<?php

class Notifications extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
		$this->load->model('ads_model');
		$this->load->model('alerts_model');
		$this->load->model('notifications_model');
		$this->load->library('email');
		$this->load->library('uri');
    }

	public function run()
	{
		$ret = array();
		$config_trigger_key = $this->config->item('notifications_trigger_key');
		$input_trigger_key  = $this->input->get('notifications_trigger_key');
		if(!empty($input_trigger_key) && $input_trigger_key == $config_trigger_key)
		{
			log_message('info', 'Notifications run script execution');

			$alerts = $this->alerts_model->get_alerts_for_notification();
			foreach($alerts as $alert)
			{
				$ads = $this->get_ads_for_alert($alert);
				if(count($ads) > 0)
				{
					$ret[] = $this->send_notification_email($alert, $ads);
				}
			}
			log_message('info', 'Notifications run script end');
		} else {
			log_message('info', 'Notifications run script not executed because trigger keys not matching ' . $input_trigger_key . ' and ' . $config_trigger_key);
		}
		return $ret;
	}

	public function index()
	{
        $data['title']  = 'Liste des notifications';

		$ret = $this->run();
		$data['emails'] = $ret;
		if( $this->input->get('mode') == 'cron')
		{
			$ret = "Hi, we are on the ". date('d/m/Y G:i:s') . " and ". count($ret) . ' notifications were sent' . "\r\n";
			$this->output->set_output($ret);
		} else {
	        $this->load->view('templates/header', $data);
	        $this->load->view('notifications/index', $data);
	        $this->load->view('templates/footer', $data);
		}
	}

	function get_ads_for_alert($alert)
	{
		$search_terms = explode(' ', $alert['search_terms']);
		foreach($search_terms as $index => $search_term)
		{
			// TODO : We need to remove alerts that have pedophilie terms.
			if(strlen($search_term) < 2)
			{
				unset($search_terms[$index]);
			}
		}
		return $this->ads_model->get_ads_by_search($search_terms, $alert);
	}

	function send_notification_email($alert, $ads)
	{
		log_message('info', 'sending email notifications');
		$ret  = array();
		$body = '';
		$number_of_ads = count($ads);
		$search_terms  = '';
		if (count($ads) > 0) // Send notification
		{

			// TODO : get the number of notifications send for this user.
			// $emails_send_for_email = $this->notifications_model->get_email_number($email, 'today');
            // do not send more than 5 emails per alert per day.
			// if(emails_send_for_email == 4)
			//{
			//	$body .= "Note : Cet email est le 4ème que vous recevez aujourd'hui pour l'alerte ". $alert['title'] . "Le maximum d'emails envoyés par jour étant 5, le prochain sera le dernier";
			//}
			// if(emails_send_for_email == 5)
			//{
			//	$body .= "Note : Cet email est le 5ème que vous recevez aujourd'hui pour l'alerte ". $alert['title'] . "Le maximum d'emails envoyés par jour étant 5, celui-ci est le dernier pour aujourd'hui :).";
			//}

			// Prepare email data
			$subject = sprintf($this->config->item('notification_email_subject'), $number_of_ads, $alert['search_terms']);

			// Build email body
			if(count($ads) == 1)
			{
				$body = $this->config->item('notification_email_body_intro_single');
			} else {
				$body = $this->config->item('notification_email_body_intro_several');
			}
			$body .= '<br /><br />';
			$body .= '<ul>'; 
			foreach($ads as $index => $ad)
			{
				$body .= '<li>' . $ad['title'] . ' : ' . sprintf('<a href="%s">%s</a>', $ad['url'], $ad['url']) . '</li>';
			}
			$body .= '</ul>';
			$body .= '<br /><br />';
			
			// Build unsubscription link
			$array_for_url['action'] = 'deactivate';
			$array_for_url['id']     = $alert['id'];
			$array_for_url['validation_key'] = $alert['validation_key'];
			$deactivate_url  = site_url('alerts/operations/' . $this->uri->assoc_to_uri($array_for_url));
			$deactivate_link = sprintf('<a href="%s">%s</a>', $deactivate_url, $deactivate_url);
			
			// End email body building :)
			$body .= sprintf($this->config->item('notification_email_deactivation_link'), $deactivate_link);
			
			// Set email other parameters
			$this->email->clear();
			$this->email->from($this->config->item('from_email'),
			                   $this->config->item('from_name'));
			$this->email->to($alert['email']);
			$this->email->subject($subject);
			$this->email->message($body);
			
			// Sending email			
			if($this->config->item('email_activated'))
			{
				if($this->email->send())
				{
					log_message('info', 'Notification email sent to ' . $alert['email'] );
				}
				else 
	    		{
					log_message('error', 'Could not send notification email to ' . $alert['email'] );
	    		}				
			}

			
			// Store the fact that we send a notification
			$this->notifications_model->set_notification($alert['id'], $number_of_ads);

    		log_message('info', 'Subject: ' . $subject );
    		log_message('info', 'From: ' . $this->config->item('from_email') );
    		log_message('info', 'Body: ' . $body );

			log_message('debug', $this->email->print_debugger());

			// Set last notification sending to now
			$this->alerts_model->set_last_notification_date($alert, date('Y-m-d H:i:s',time()));
			
			$ret[] = array('subject' => $subject, 'body' => $body, 'email_address' => $alert['email']);
			
		}
		return $ret;
	}

}

/* End of file notifications.php */
/* Location: ./application/controllers/notifications.php */