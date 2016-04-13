<?php


namespace MVKaran\Exotel;

use GuzzleHttp\Client as GuzzleClient;


class Client {

    protected $sid;
    protected $token;
    protected $client;

    public function __construct($sid, $token)
    {
        $this->sid = $sid;
        $this->token = $token;

        $this->client = new GuzzleClient([
            'base_uri' => 'https://'. $this->sid . ':' . $this->token . '@twilix.exotel.in/v1/Accounts/' . $this->sid . '/'
        ]);
    }

    /**
     * First dials the 'from' number and when received, dials the 'to' number and connects them
     * 'caller_id' number is shown to both the numbers.
     *
     * @param array $details
     *
     *
     * details [
     * 'from', //Mandatory
     * 'to', //Mandatory
     * 'caller_id', //Mandatory
     * 'time_limit',
     * 'time_out',
     * 'status_callback',
     * ]
     */
    public function call_number($details = array())
    {
        if(empty($details['from']) || empty($details['to']) || empty($details['caller_id']) )
            throw new InsufficientParametersException('call_number');

        $response = $this->client->request('POST', 'Calls/connect.json', [
            'http_errors' => false,
            'form_params' => [
                'From' => $details['from'],
                'To' => $details['to'],
                'CallerId' => $details['caller_id'],
                'TimeLimit' => isset($details['time_limit']) ? $details['time_limit'] : "",
                'TimeOut' => isset($details['time_out']) ? $details['time_out'] : "",
                'StatusCallback' => isset($details['status_callback']) ? $details['status_callback'] : "",
            ]
        ] );

        $code = $response->getStatusCode();
        $reasonPhrase = $response->getReasonPhrase();
        $body = (string) $response->getBody();

        if($code == 200)
            return $body;
        else if($code == 429)
            throw new RateLimitExceededException();
        else {
            $exception = json_decode($body, true);
            throw new ExotelException($exception['RestException']['Message']);
        }


    }

    /**
     * First dials the 'to' number and when received, connects the call to the 'app_id' flow mentioned
     * 'caller_id' number is shown to the 'to' number user
     *
     * @param array $details
     *
     *
     * details [
     * 'to', //Mandatory
     * 'app_id', //Mandatory
     * 'caller_id', //Mandatory
     * 'time_limit',
     * 'time_out',
     * 'status_callback',
     * 'custom_field',
     * ]
     */
    public function call_flow($details = array())
    {
        if(empty($details['to']) || empty($details['app_id']) || empty($details['caller_id']) )
            throw new InsufficientParametersException('call_flow');

        $response = $this->client->request('POST', 'Calls/connect.json', [
            'http_errors' => false,
            'form_params' => [
                'From' => $details['to'],
                'Url' => 'http://my.exotel.in/exoml/start/' . $details['app_id'],
                'CallerId' => $details['caller_id'],
                'TimeLimit' => isset($details['time_limit']) ? $details['time_limit'] : "",
                'TimeOut' => isset($details['time_out']) ? $details['time_out'] : "",
                'StatusCallback' => isset($details['status_callback']) ? $details['status_callback'] : "",
                'CustomField' => isset($details['custom_field']) ? $details['custom_field'] : "",
            ]
        ] );

        $code = $response->getStatusCode();
        $reasonPhrase = $response->getReasonPhrase();
        $body = (string) $response->getBody();

        if($code == 200)
            return $body;
        else if($code == 429)
            throw new RateLimitExceededException();
        else {
            $exception = json_decode($body, true);
            throw new ExotelException($exception['RestException']['Message']);
        }

    }

    /**
     * Sends an SMS to the 'to' number with 'body' as message body and 'priority'
     *
     *
     * @param array $details
     *
     *
     * details [
     * 'from', //Mandatory
     * 'to', //Mandatory
     * 'body', //Mandatory
     * 'priority',
     * 'status_callback',
     * ]
     */
    public function send_sms($details = array())
    {
        if(empty($details['from']) || empty($details['to']) || empty($details['body']) )
            throw new InsufficientParametersException('send_sms');

        $response = $this->client->request('POST', 'Sms/send.json', [
            'http_errors' => false,
            'form_params' => [
                'From' => $details['from'],
                'To' => $details['to'],
                'Body' => $details['body'],
                'Priority' => isset($details['priority']) ? $details['priority'] : "normal",
                'StatusCallback' => isset($details['status_callback']) ? $details['status_callback'] : "",

            ]
        ] );

        $code = $response->getStatusCode();
        $reasonPhrase = $response->getReasonPhrase();
        $body = (string) $response->getBody();

        if($code == 200)
            return $body;
        else if($code == 429)
            throw new RateLimitExceededException();
        else {
            $exception = json_decode($body, true);
            throw new ExotelException($exception['RestException']['Message']);
        }
    }

    /**
     * Get the details of an SMS identified by 'sms_sid'
     *
     * @param String $sms_sid
     */
    public function sms_details($sms_sid)
    {
        if(empty($sms_sid) )
            throw new InsufficientParametersException('sms_details');

        $response = $this->client->request('GET', 'Sms/Messages/' . $sms_sid . '.json', [
            'http_errors' => false,
        ] );

        $code = $response->getStatusCode();
        $reasonPhrase = $response->getReasonPhrase();
        $body = (string) $response->getBody();

        if($code == 200)
            return $body;
        else if($code == 429)
            throw new RateLimitExceededException();
        else {
            $exception = json_decode($body, true);
            throw new ExotelException($exception['RestException']['Message']);
        }
    }

    /**
     * Get the details of a Call identified by 'call_sid'
     *
     * @param String $call_sid
     */
    public function call_details($call_sid)
    {
        if(empty($call_sid) )
            throw new InsufficientParametersException('sms_details');

        $response = $this->client->request('GET', 'Calls/' . $call_sid . '.json', [
            'http_errors' => false,
        ] );

        $code = $response->getStatusCode();
        $reasonPhrase = $response->getReasonPhrase();
        $body = (string) $response->getBody();

        if($code == 200)
            return $body;
        else if($code == 429)
            throw new RateLimitExceededException();
        else {
            $exception = json_decode($body, true);
            throw new ExotelException($exception['RestException']['Message']);
        }
    }
}