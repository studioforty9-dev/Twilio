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
 * Studioforty9_Twilio_Test_Model_Sms
 *
 * @category   Studioforty9
 * @package    Studioforty9_Twilio
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Twilio_Test_Model_Sms extends EcomDev_PHPUnit_Test_Case
{
    /** @var string */
    private $_alias = 'studioforty9_twilio/sms';

    /** @var string */
    private $_accountId = 'AC7c0a8d726aaced458bba8e9a9b5536cf';

    /** @var string */
    private $_authToken = '7cb0fc5d007a50fb5acd6373b86e6a7e';

    /**
     * @test
     */
    public function it_can_set_an_alternative_http_client()
    {
        $client = new Zend_Http_Client();
        $client->setAdapter(new Zend_Http_Client_Adapter_Test());
        $model = Mage::getModel($this->_alias, array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken,
            'client'    => $client
        ));
        $actual = $model->getClient();
        $this->assertEquals('Zend_Http_Client', get_class($actual));
        $this->assertInstanceOf('Zend_Http_Client_Adapter_Test', $actual->getAdapter());
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_can_throws_exception_when_attempting_to_set_non_zend_http_client()
    {
        Mage::getModel($this->_alias, array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken,
            'client'    => new stdClass()
        ));
    }

    /**
     * @test
     */
    public function it_continues_chaining_on_set_to()
    {
        $model = Mage::getModel($this->_alias, array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken
        ));

        $this->assertInstanceOf('Studioforty9_Twilio_Model_Sms', $model->setTo('foo'));
    }

    /**
     * @test
     */
    public function it_continues_chaining_on_set_from()
    {
        $model = Mage::getModel($this->_alias, array(
                'accountId' => $this->_accountId,
                'authToken' => $this->_authToken
        ));

        $this->assertInstanceOf('Studioforty9_Twilio_Model_Sms', $model->setFrom('bar'));
    }

    /**
     * @test
     */
    public function it_continues_chaining_on_set_body()
    {
        $model = Mage::getModel($this->_alias, array(
                'accountId' => $this->_accountId,
                'authToken' => $this->_authToken
        ));

        $this->assertInstanceOf('Studioforty9_Twilio_Model_Sms', $model->setBody('baz'));
    }

    /**
     * @test
     */
    public function it_formats_the_uri_correctly()
    {
        $response = new Zend_Http_Response('200', array(), '{"success":true}');
        $adapter = new Zend_Http_Client_Adapter_Test();
        $adapter->setResponse($response);
        $client = new Zend_Http_Client();
        $client->setAdapter($adapter);

        $model = new Studioforty9_Twilio_Model_Sms(array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken,
            'client'    => $client
        ));

        $model->setTo('+353867926667')
            ->setFrom('+15005550008')
            ->setBody('Hello!')
            ->send();

        $this->assertEquals(
            'https://api.twilio.com:443/2010-04-01/Accounts/'.$this->_accountId.'/Messages.json',
            $client->getUri()->__toString()
        );
    }

    /**
     * @test
     */
    public function it_sets_the_correct_authentication_paramaters()
    {
        $response = new Zend_Http_Response('200', array(), '{"success":true}');
        $adapter = new Zend_Http_Client_Adapter_Test();
        $adapter->setResponse($response);
        $client = new Zend_Http_Client();
        $client->setAdapter($adapter);

        $model = new Studioforty9_Twilio_Model_Sms(array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken,
            'client'    => $client
        ));

        $model->setTo('+353867926667')->setFrom('+15005550008')->setBody('Hello!')->send();

        $this->assertContains(
            'Authorization: Basic ' . base64_encode($this->_accountId.':'.$this->_authToken),
            $client->getLastRequest()
        );
    }

    /**
     * @test
     * @expectedException        RuntimeException
     * @expectedExceptionMessage [21301] Testing error formatting. (http://api.twilio.com/some-helpful-link)
     */
    public function it_throws_request_error_exceptions_in_the_expected_format()
    {
        $response = new Zend_Http_Response('500', array(), json_encode(array(
            'code' => '21301',
            'message' => 'Testing error formatting.',
            'more_info' => 'http://api.twilio.com/some-helpful-link'
        )));
        $adapter = new Zend_Http_Client_Adapter_Test();
        $adapter->setResponse($response);
        $client = new Zend_Http_Client();
        $client->setAdapter($adapter);

        $model = new Studioforty9_Twilio_Model_Sms(array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken,
            'client'    => $client
        ));

        $model->setTo('+353867926667')->setFrom('+15005550008')->setBody('Hello!')->send();
    }

    /**
     * @test
     */
    public function it_can_send_a_message()
    {
        $to   = '+353867926667';
        $from = '+15005550006';
        $body = 'Hello!';

        $model = new Studioforty9_Twilio_Model_Sms(array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken
        ));

        $response = $model->setTo($to)
            ->setFrom($from)
            ->setBody($body)
            ->send();

        $this->assertArrayHasKey('sid', $response);
        $this->assertArrayHasKey('date_created', $response);
        $this->assertArrayHasKey('date_updated', $response);
        $this->assertArrayHasKey('date_sent', $response);
        $this->assertArrayHasKey('account_sid', $response);
        $this->assertArrayHasKey('to', $response);
        $this->assertArrayHasKey('from', $response);
        $this->assertArrayHasKey('body', $response);
        $this->assertArrayHasKey('status', $response);
        $this->assertArrayHasKey('num_segments', $response);
        $this->assertArrayHasKey('num_media', $response);
        $this->assertArrayHasKey('direction', $response);
        $this->assertArrayHasKey('api_version', $response);
        $this->assertArrayHasKey('price', $response);
        $this->assertArrayHasKey('price_unit', $response);
        $this->assertArrayHasKey('uri', $response);
        $this->assertArrayHasKey('subresource_uris', $response);

        $this->assertEquals($this->_accountId, $response['account_sid']);
        $this->assertEquals($to, $response['to']);
        $this->assertEquals($from, $response['from']);
        $this->assertEquals($body, $response['body']);
    }

    /**
     * @test
     * @expectedException RuntimeException
     * @expectedExceptionMessage [21611] SMS queue is full. (https://www.twilio.com/docs/errors/21611)
     */
    public function it_throws_an_exception_when_it_encounters_an_error()
    {
        $model = new Studioforty9_Twilio_Model_Sms(array(
            'accountId' => $this->_accountId,
            'authToken' => $this->_authToken
        ));

        $model->setTo('+353867926667')
            ->setFrom('+15005550008')
            ->setBody('Hello!')
            ->send();
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_throws_exception_when_constructor_missing_account_id()
    {
        new Studioforty9_Twilio_Model_Sms(array(
            'accountId' => '',
            'authToken' => $this->_authToken
        ));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_throws_exception_when_constructor_missing_auth_token()
    {
        new Studioforty9_Twilio_Model_Sms(array(
            'accountId' => $this->_accountId,
            'authToken' => ''
        ));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_throws_exception_when_constructor_missing_account_id_via_get_model()
    {
        Mage::getModel($this->_alias, array('authToken' => $this->_authToken));
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     */
    public function it_throws_exception_when_constructor_missing_auth_token_get_model()
    {
        Mage::getModel($this->_alias, array('accountId' => $this->_accountId));
    }
}
