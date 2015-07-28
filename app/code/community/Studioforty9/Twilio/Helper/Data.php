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
 * Studioforty9_Twilio_Helper_Data
 *
 * @category   Studioforty9
 * @package    Studioforty9_Twilio
 * @subpackage Helper
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Twilio_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Determine if the twilio extension is enabled via the configuration.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return (bool) Mage::getStoreConfigFlag('studioforty9_twilio/settings/enabled');
    }

    /**
     * Get the authentication token provided.
     *
     * @return bool
     */
    public function getAuthToken()
    {
        return Mage::getStoreConfig('studioforty9_twilio/auth/token');
    }

    /**
     * Get the account id provided.
     *
     * @return bool
     */
    public function getAccountId()
    {
        return Mage::getStoreConfig('studioforty9_twilio/auth/account_id');
    }

    /**
     * Send a message via Twilio's API.
     *
     * @param  string $to
     * @param  string $from
     * @param  string $message
     * @return array
     * @throws RuntimeException
     */
    public function sendMessage($to, $from, $message)
    {
        if (!$this->isEnabled()) {
            throw new RuntimeException('The Twilio extension is disabled via configuration.');
        }

        $sms = Mage::getModel('studioforty9_twilio/sms', array(
            'accountId' => $this->getAccountId(),
            'authToken' => $this->getAuthToken()
        ));
        $sms->setTo($to)->setFrom($from)->setBody($message);
        return $sms->send();
    }
}
