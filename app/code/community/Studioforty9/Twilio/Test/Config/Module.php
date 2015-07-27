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
 * Studioforty9_Twilio_Test_Config_Module
 *
 * @category   Studioforty9
 * @package    Studioforty9_Twilio
 * @subpackage Test
 * @author     StudioForty9 <info@studioforty9.com>
 */
class Studioforty9_Twilio_Test_Config_Module extends EcomDev_PHPUnit_Test_Case_Config
{
    public function test_module_is_in_correct_code_pool()
    {
        $this->assertModuleCodePool('community');
    }


    public function test_module_version_is_correct()
    {
        $this->assertModuleVersion('1.0.0');
    }

    public function test_block_are_configured()
    {
        $this->assertBlockAlias('studioforty9_twilio/data', 'Studioforty9_Twilio_Block_Data');
    }

    public function test_models_are_configured()
    {
        $this->assertModelAlias('studioforty9_twilio/sms', 'Studioforty9_Twilio_Model_Sms');
    }

    public function test_helpers_are_configured()
    {
        $this->assertHelperAlias('studioforty9_twilio/data', 'Studioforty9_Twilio_Helper_Data');
    }

    public function test_access_granted_for_config_acl()
    {
        $this->assertConfigNodeValue(
            'adminhtml/acl/resources/admin/children/system/children/config/children/studioforty9_twilio/title',
            'Twilio Configuration Settings'
        );
    }

    public function test_translate_nodes_are_correct()
    {
        $this->assertConfigNodeValue(
            'frontend/translate/modules/studioforty9_twilio/files/default',
            'Studioforty9_Twilio.csv'
        );
    }
}
