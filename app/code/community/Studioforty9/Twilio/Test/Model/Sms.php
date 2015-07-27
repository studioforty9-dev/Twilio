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
    private $_accountId = 'AC7c0a8d726aaced458bba8e9a9b5536cf';

    /** @var string */
    private $_authToken = '7cb0fc5d007a50fb5acd6373b86e6a7e';

    /**
     * @test
     */
    public function it_can_send_a_message()
    {
        $to   = '+353867926667';
        $from = '+15005550006';
        $body = 'Hello!';

        $model = new Studioforty9_Twilio_Model_Sms($this->_accountId, $this->_authToken);

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
        $to   = '+353867926667';
        $from = '+15005550008';
        $body = 'Hello!';

        $model = new Studioforty9_Twilio_Model_Sms($this->_accountId, $this->_authToken);

        $model->setTo($to)
            ->setFrom($from)
            ->setBody($body)
            ->send();
    }
}
