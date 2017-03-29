<?php
class Alerts extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('alerts_model');
		$this->load->model('ads_model');
		$this->load->library('email');
		$this->load->library('uri');
    }

    public function index()
    {
        $data['alerts'] = $this->alerts_model->get_alerts();
        $data['title']  = 'Liste des alertes';

        $this->load->view('templates/header', $data);
        $this->load->view('alerts/index', $data);
        $this->load->view('templates/footer', $data);
    }

	/*
	// This function performs alert activation, deactivation and email validation resend
	//
	*/

    public function operations()
    {
		// Retreive data from URL
		$default = array('id', 'action', 'validation_key');
		$vars    = $this->uri->uri_to_assoc(3, $default);
		
		// For templates
		$data['vars']  = $vars;
		$data['res']   = 0;
		$data['title'] = "Opération sur les alertes";
		
		// Process alert operation
		switch ($vars['action']) {
		    case 'validate_email':
				// $this->update_alert_active_status($vars['id'], $vars['validation_key'], true);
				$res = $this->validate_email(urldecode($vars['email']), $vars['validation_key']);
				$data['res']   = $res ? 1 : 0;
				$data['title'] = "Activation d'alerte";
		        break;
		    case 'deactivate':
				$res = $this->update_alert_status($vars['id'], $vars['validation_key'], 2);
				$data['res']   = $res ? 2 : 0;
				$data['title'] = "Désactivation d'alerte";
		        break;
		    case 'resend_validation_email':
				$res = $this->resend_validation_email(urldecode($vars['email']), $vars['validation_key']);
				$data['res']   = $res ? 3 : 0;
				$data['title'] = "Renvoie d'email d'activation";
				$data['email']   = urldecode($vars['email']);
		        break;
		}
				
		// Load templates
        $this->load->view('templates/header', $data);
        $this->load->view('alerts/operations', $data);
        $this->load->view('templates/footer', $data);
    }


	public function email_check($email)
	{
		$res = false;
		$email_list = $this->config->item('allowed_emails');
		if (!empty($email_list) && in_array($email, $email_list))
		{
			$res = true;
		}
		else
		{
			$this->form_validation->set_message('email_check', sprintf($this->config->item('email_not_allowed'), $email));
			$res = false;
		}
		return $res;
	}
	// This function deals with alert creation.
    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

		// For template
        $data['title']  = "Création d'une alerte";

		// Check input validation rules
        $this->form_validation->set_rules('email', '"Email"', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('search_terms', '"Recherche"', 'required');
        
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('pages/home', $data);
            $this->load->view('templates/footer', $data);
        }
        else  // Everything's validated, alert creation process
        {

			// Prevent users from having more than 15 alerts
			$user_active_alerts = $this->alerts_model->get_active_alerts_by_email($this->input->post('email'));
			if($user_active_alerts >= 15) // Should be == 15 but we never know
			{
				$data['insert_result'] = 4;
			} else {

				// Check whether email has been validated (at least one alert is active or archived)
				$email_validated = $this->alerts_model->is_email_validated($this->input->post('email'));
				$email_validated = ($email_validated > 0) ? true : false;

				// Perform alert creation and get result of the operation
            	$insert_res = $this->alerts_model->set_alert($email_validated);

				if($insert_res && !$email_validated)
				{
					$data['insert_result'] = 1;
				} elseif($insert_res && $email_validated)
				{
					$data['insert_result'] = 5;
				}

				// Get alert id since we need some data from it later
            	$alert_id = $this->db->insert_id();
            	$alert    = $this->alerts_model->get_alert_by_id($alert_id);

				// For templates
				$data['alert'] = $alert;

				// Alert has been created correctly
            	if(!empty($alert))
            	{            	
					// Get the number of existing alerts for email
					$not_active_alerts_number = $this->alerts_model->get_not_active_alerts_by_email($alert['email']);
					if(!$email_validated && $not_active_alerts_number <= 1)
					{
						log_message('info', 'Alert creation. Sending validation email to user.' );

						// Creating the link to validate email.
						// URI pattern: action/validate_email/id/39/validation_key/8796976BJBKDS
						$array_for_url['action'] = 'validate_email';
						$array_for_url['email']     = urlencode($alert['email']);
						$array_for_url['validation_key'] = $alert['validation_key'];
						$href = site_url('alerts/operations/' . $this->uri->assoc_to_uri($array_for_url));
						
	            		$subject = $this->config->item('alert_email_validation_email_subject');
	            		$body    = sprintf($this->config->item('alert_email_validation_body'), $href);

	            		log_message('info', 'Subject: ' . $subject );
	            		log_message('info', 'Body: ' . $body );

						// Set email other parameters
						$this->email->clear();
						$this->email->from($this->config->item('from_email'),
						                   $this->config->item('from_name'));
        				$this->email->to($alert['email']);
        				$this->email->subject($subject);
        				$this->email->message($body);

						// Send email
						if($this->config->item('email_activated'))
						{
							if($this->email->send())
							{
								log_message('info', 'Alert creation email sent to email ' . $alert['email'] );
							}
							else 
				    		{
								log_message('error', 'Alert creation email NOT SENT to email ' . $alert['email'] );
				    		}
						}
					}

					// User has been creating alerts without validating the email address, we do not send another email
					// but propose him to check spam folder and resend a validation email by displaying a message.
					elseif(!$email_validated && $not_active_alerts_number > 1)
					{
						log_message('info', 'Alert creation. User email not validated, no email sent.' );

						// Creating the link to resend validation email.
						// URI pattern: email/test%40labonnealerte.fr/action/resend_validation_email/validation_key/8796976BJBKDS
						$array_for_url['action'] = 'resend_validation_email';
						$array_for_url['email']     = urlencode($alert['email']);
						$array_for_url['validation_key'] = $alert['validation_key'];
						$href = site_url('alerts/operations/' . $this->uri->assoc_to_uri($array_for_url));

						// For templates
	            		$data['resend_link']   = $href;
						$data['insert_result'] = 2;
					}
					else
					{
						log_message('info', 'No need to send again validation email since email (' . $alert['email'] . ') is already validated.' );
					}
					log_message('debug', $this->email->print_debugger());                
            	}
            	else // if(!empty($alert))
            	{
					// For templates
	            	$data['insert_result'] = 0;
            	} 
			}
            $this->load->view('templates/header', $data);
            $this->load->view('pages/home', $data);
            $this->load->view('templates/footer', $data);
        }

    }

	public function update_alert_status($id, $provided_validation_key, $value = 0)
	{
		$res = false;
		$stored_validation_key = $this->alerts_model->get_alert_validation_key($id);
		if($stored_validation_key == $provided_validation_key)
		{
			// We deactivate that specific alert ($id)
			$res = $this->alerts_model->update_alert_status($id, $value);
		}
		return $res;
	}

    public function resend_validation_email($email, $provided_validation_key)
	{
		$res = true;
		
		log_message('info', 'Email ' . $email . ' requested that we resend validation email');
		
		if($this->alerts_model->email_key_match($email, $provided_validation_key))
		{
			log_message('info', 'Resending validation email to email (' . $email . ') since validation_key and email match');
			
			$array_for_url['action'] = 'validate_email';
			$array_for_url['email']  = urlencode($email);
			$array_for_url['validation_key'] = $provided_validation_key;
			$href = site_url('alerts/operations/' . $this->uri->assoc_to_uri($array_for_url));
			
    		$subject = $this->config->item('alert_email_resend_validation_email_subject');
    		$body    = sprintf($this->config->item('alert_email_resend_validation_body'), $href);

    		log_message('info', 'Subject: ' . $subject );
    		log_message('info', 'Body: ' . $body );

			// Set email other parameters
			$this->email->clear();
			$this->email->from($this->config->item('from_email'),
			                   $this->config->item('from_name'));
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($body);

			// Send email
			if($this->config->item('email_activated'))
			{
				if($this->email->send())
				{
					log_message('info', 'Email validation resent to ' . $email );
				}
				else 
	    		{
					log_message('error', 'Could not resend validation email to ' . $email );
	    		}			
			}
		} else {
			log_message('info', 'Cannot resent validation email to ' . $email . ' because validation_key and email do not match');
		}
		
		return $res;
	}
	
	public function validate_email($email, $validation_key)
	{
		$res   = false;
		$match = $this->alerts_model->email_key_match($email, $validation_key);
		
		if($match)
		{
			$res = $this->alerts_model->activate_alerts_by_email($email);
		}
		return $res;
	}

    public function delete($id)
    {
        $data['title']  = "Suppression de l'alerte";

        if(!empty($id))
        {
            //$data['res'] = $this->alerts_model->delete($id);
            $data['id']  = $id;
            $this->load->view('templates/header', $data);
            $this->load->view('alerts/delete', $data);
            $this->load->view('templates/footer', $data);
        }
        
    }

}