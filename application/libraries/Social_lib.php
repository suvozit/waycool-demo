<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

use GuzzleHttp\Exception\RequestException;

class Social_lib
{
	private $error = NULL;

	private $client = NULL;

	function __construct($param)
	{
		$this->ci =& get_instance();

		$this->ci->load->helper('url');

		$this->ci->config->load('social', TRUE);
		$this->config = $this->ci->config->item($param['app'], 'social');
		$this->config['redirect_url'] = base_url('social/callback/'.$param['app']);

		$this->client = new GuzzleHttp\Client([
			'http_errors' => FALSE, // Set to false to disable throwing exceptions on an HTTP protocol errors (i.e., 4xx and 5xx responses).
			'timeout' => 60.0,
			// 'debug' => TRUE,
		]);
	}

	function get_error_message()
	{
		return $this->error;
	}

	function get_request_token()
	{
		$query = $this->config['authorize_params'];

		$query['client_id']      = $this->config['client_id'];
		$query['redirect_uri']   = $this->config['redirect_url'];

		// construct authorize url
		$authorize_url = $this->config['authorize_url'].'?'.http_build_query($query);

		redirect($authorize_url);
	}

	function get_access_token()
	{
		$code = $this->ci->input->get('code');
		if (empty($code))
		{
			$this->error = 'Request denied';
			return NULL;
		}

		$http_method = 'POST';
		$options['form_params'] = [
			'code'          => $code,
			'client_id'     => $this->config['client_id'],
			'client_secret' => $this->config['client_secret'],
			'redirect_uri'  => $this->config['redirect_url'],
			'grant_type'    => 'authorization_code',
		];

		$options['headers'] = [
			'Accept'  => 'application/json',
			'Authorization' => 'Basic '.base64_encode($this->config['client_id'].':'.$this->config['client_secret']),
		];

		if (is_null($response = $this->request($this->config['access_token_url'], $http_method, $options)))
		{
			return NULL;
		}

		$response = json_decode($response['body'], TRUE);
		return $response['access_token'];
	}

	function fetch_facebook($access_token)
	{
		$options['query']['access_token'] = $access_token;
		$options['query']['fields'] = 'name,email';

		$url = 'https://graph.facebook.com/v4.0/me';

		if (is_null($response = $this->request($url, 'POST', $options, 200)))
        {
            return NULL;
        }

        return json_decode($response['body'], TRUE);
	}

	function fetch_google($access_token)
	{
		$options['query']['access_token'] = $access_token;
		$options['query']['personFields'] = 'names,emailAddresses';

		$url = 'https://people.googleapis.com/v1/people/me';

		if (is_null($response = $this->request($url, 'GET', $options, 200)))
        {
            return NULL;
        }

        $response = json_decode($response['body'], TRUE);

        $data = [
        	'id' 	=> $response['names'][0]['metadata']['source']['id'],
        	'name' 	=> $response['names'][0]['givenName'].' '.$response['names'][0]['familyName'],
        	'email' => $response['emailAddresses'][0]['value'],
        ];

        return $data;
	}

	function request($url, $http_method = 'GET', $options = array(), $expected_status = 200)
	{
		$response = NULL;
		try {
		  $response = $this->client->request($http_method, $url, $options);
		}
		catch (RequestException $e) {
		  if ($e->hasResponse()) $response = $e->getResponse();
		}
		if (empty($response))
		{
			$this->error = 'Empty response';
			return NULL;
		}
		else
		{
			$status = $response->getStatusCode();
			$body   = $response->getBody()->getContents();
			$header = $response->getHeaders();
			if ($expected_status !== 0 AND $status !== $expected_status)
			{
				$this->error = $status.' '.$body;
				return NULL;
			}
			return compact('status', 'header', 'body');
		}
	}
}