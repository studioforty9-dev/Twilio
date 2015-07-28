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
 * Studioforty9_Twilio_Test_Helper_Data
 *
 * @category   Studioforty9
 * @package    Studioforty9_Twilio
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Twilio_Test_Helper_Data extends EcomDev_PHPUnit_Test_Case
{
    private $_alias = 'studioforty9_twilio/data';

    /**
     * @test
     */
    public function it_can_get_config_value_to_determine_if_enabled()
    {
        $helper = Mage::helper($this->_alias);

        $this->assertInternalType('boolean', $helper->isEnabled());
    }

    /**
     * @test
     */
    public function it_can_get_config_value_for_auth_token()
    {
        $helper = Mage::helper($this->_alias);

        $this->assertInternalType('string', $helper->getAuthToken());
    }

    /**
     * @test
     */
    public function it_can_get_config_value_for_account_id()
    {
        $helper = Mage::helper($this->_alias);

        $this->assertInternalType('string', $helper->getAccountId());
    }

    /**
     * @test
     */
    public function it_can_send_message_using_configuration_for_auth_credentials()
    {
        $this->getHelperMockObject(array(
            'isEnabled'    => array('return' => true, 'expect' => $this->once()),
            'getAccountId' => array('return' => 'foo', 'expect' => $this->once()),
            'getAuthToken' => array('return' => 'bar', 'expect' => $this->once())
        ));

        $mockClient = new Zend_Http_Client();
        $mockClient->setAdapter(new Zend_Http_Client_Adapter_Test());

        $this->getMockModelObject($disableConstructor = true, array(
            'getClient' => array('return' => $mockClient, 'expect' => $this->any()),
            'send'      => array('return' => array('baz'), 'expect' => $this->once())
        ));

        Mage::helper($this->_alias)->sendMessage('+353861234567', '+353867654321', 'Hello!');
    }

    /**
     * Get a mock studioforty9_twilio/sms model object.
     *
     * @param  bool  $disableConstructor
     * @param  array $methods
     * @return mixed
     */
    private function getMockModelObject($disableConstructor = true, $methods = array())
    {
        $mock = $this->getModelMockBuilder('studioforty9_twilio/sms');

        if ($disableConstructor) {
            $mock->disableOriginalConstructor();
        }

        if (empty($methods)) {
            return $mock->getMock();
        }
        $methodNames = array_keys($methods);
        $mock = $mock->setMethods($methodNames)->getMock();
        foreach ($methods as $name => $options) {
            if (isset($options['expect']) && isset($options['return'])) {
                $mock->expects(isset($options['expect']) ? $options['expect'] : $this->any())
                    ->method($name)
                    ->will($this->returnValue($options['return']));
            }
        }
        $this->replaceByMock('model', 'studioforty9_twilio/sms', $mock);
    }

    /**
     * Get a mock studioforty9_twilio/data helper object.
     *
     * @param  array $methods
     * @return mixed
     */
    protected function getHelperMockObject($methods = array())
    {
        $mock = $this->getHelperMockBuilder('studioforty9_twilio/data');
        if (empty($methods)) {
            return $mock->getMock();
        }
        $methodNames = array_keys($methods);
        $mock = $mock->setMethods($methodNames)->getMock();
        foreach ($methods as $name => $options) {
            if (isset($options['expect']) && isset($options['return'])) {
                $mock->expects(isset($options['expect']) ? $options['expect'] : $this->any())
                    ->method($name)
                    ->will($this->returnValue($options['return']));
            }
        }
        $this->replaceByMock('helper', 'studioforty9_twilio/data', $mock);
        return $mock;
    }
}
