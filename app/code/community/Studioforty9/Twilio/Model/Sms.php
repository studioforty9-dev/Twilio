<?php
/**
 * Studioforty9_Twilio
 *
 * @category  Studioforty9
 * @package   Studioforty9_Twilio
 * @author    StudioForty9 <info@studioforty9.com>
 * @copyright 2015 StudioForty9 (http://www.studioforty9.com)
 * @license   https://github.com/studioforty9/twilio/blob/master/LICENCE BSD
 * @version   1.0.0
 * @link      https://github.com/studioforty9/twilio
 */

/**
 * Studioforty9_Twilio_Model_Sms
 *
 * @category   Studioforty9
 * @package    Studioforty9_Twilio
 * @subpackage Model
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Twilio_Model_Sms extends Mage_Core_Model_Abstract
{
    /** @var string */
    protected $_endpoint = 'https://api.twilio.com/2010-04-01/';

    /** @var string */
    protected $_uri = 'Accounts/{account_id}/Messages.json';

    /** @var string */
    protected $_authToken;

    /** @var string */
    protected $_accountId;

    /** @var string */
    protected $_to;

    /** @var string */
    protected $_from;

    /** @var string */
    protected $_body;

    /**
     * Construct a new SMS model.
     *
     * @param  array $config
     * @throws InvalidArgumentException
     */
    public function __construct($config = array())
    {
        if (!isset($config['accountId']) || empty($config['accountId'])) {
            throw new InvalidArgumentException('Missing Account ID parameter.');
        }

        if (!isset($config['authToken']) || empty($config['authToken'])) {
            throw new InvalidArgumentException('Missing Auth Token parameter.');
        }

        if (isset($config['client']) && !$config['client'] instanceof Zend_Http_Client) {
            throw new InvalidArgumentException('Invalid Http Client, you must use or extend Zend_Http_Client.');
        }

        $this->_accountId = $config['accountId'];
        $this->_authToken = $config['authToken'];
        $this->_client = (!isset($config['client']) || !$config['client'] instanceof Zend_Http_Client)
            ? new Varien_Http_Client()
            : $config['client'];
    }

    /** @var Zend_Http_Client */
    protected $_client;

    /**
     * Set the number to send to.
     * (e.g. +353861234567)
     *
     * @param  string $number
     * @return $this
     */
    public function setTo($number)
    {
        $this->_to = $number;
        return $this;
    }

    /**
     * Set the number to send from.
     * (e.g. a registered twilio number or the twilio test number)
     *
     * @param  string $number
     * @return $this
     */
    public function setFrom($number)
    {
        $this->_from = $number;
        return $this;
    }

    /**
     * Set the body text.
     *
     * @param  string $message
     * @return $this
     * @throws InvalidArgumentException When length > 1600
     */
    public function setBody($message)
    {
        if (strlen($message) > 1600) {
            throw new InvalidArgumentException(
                'The message body must not be more than 1600 characters.'
            );
        }

        $this->_body = $message;
        return $this;
    }

    /**
     * Get the HTTP request client.
     *
     * @return Zend_Http_Client
     */
    public function getClient()
    {
        return $this->_client;
    }

    /**
     * Send the SMS message.
     *
     * @return array
     * @throws RuntimeException
     */
    public function send()
    {
        $client = $this->getClient();
        $client->setAuth($this->_accountId, $this->_authToken);
        $client->setUri($this->_getFormattedUri());
        $client->setParameterPost('To', $this->_to);
        $client->setParameterPost('From', $this->_from);
        $client->setParameterPost('Body', $this->_body);

        $response = $client->request(Zend_Http_Client::POST);

        if (!$response->isSuccessful()) {
            return $this->_handleError($response);
        }

        return $this->_handleSuccess($response);
    }

    /**
     * Interpolate the uri with the Twilio Account ID.
     *
     * @return string
     */
    protected function _getFormattedUri()
    {
        $url = $this->_endpoint . $this->_uri;
        return str_replace('{account_id}', $this->_accountId, $url);
    }

    /**
     * Handle the API response data when the request is not successful.
     *
     * @param  Zend_Http_Response $response
     * @throws RuntimeException
     */
    protected function _handleError($response)
    {
        $json = json_decode($response->getBody(), true);
        throw new RuntimeException(
            sprintf(
                '[%s] %s (%s)',
                $json['code'],
                $json['message'],
                $json['more_info']
            )
        );
    }

    /**
     * Handle the API response data when the request is successful.
     *
     * @param  Zend_Http_Response $response
     * @return array
     */
    protected function _handleSuccess($response)
    {
        return json_decode($response->getBody(), true);
    }
}
