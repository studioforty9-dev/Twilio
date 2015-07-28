# Twilio
Developer extension to enable simple SMS sending via Magento for your custom modules.


## Composer Installation

Add the package to your require list:

```json
"require": {
    "studioforty9/twilio": "dev-master"
}
```

Add the repository to your project composer.json file:

```json
"repositories": [
    {"type": "vcs", "url": "https://github.com/studioForty9/twilio"}
],
```

## Usage

#### Via the helper method (uses your configuration settings)

```php
$response = Mage::helper('studioforty9_twilio')->sendMesssage($to, $from, $message);

```

#### Via the model (add your Account ID and Auth Token manually)

```php
/* You can 'new' up an object like this:
$sms = new Studioforty9_Twilio_Model_Sms(array(
    'accountId' => $accountId, 
    'authToken' => $authToken
));
*/
// Or use the typical Magento getModel approach
$sms = Mage::getModel('studioforty9_twilio/sms', array(
    'accountId' => $accountId, 
    'authToken' => $authToken
));

$response = $sms->setTo('+12345678901')
  ->setFrom('+12345678901')
  ->setBody('Your message')
  ->send();

```

#### Using a custom HTTP client

If you need to use a custom HTTP client for any reason (we use `Varien_Http_Client` by default) - you can inject an intance of `Zend_Http_Client` into the `Studioforty9_Twilio_Model_Sms` class via the `$config` array.

```php
$client = new Zend_Http_Client();
$sms = Mage::getModel('studioforty9_twilio/sms', array(
    'accountId' => $accountId, 
    'authToken' => $authToken,
    'client'    => $client
));

```

> Media SMS is currently unsupported.

## Contributing

[see CONTRIBUTING file](https://github.com/studioforty9/twilio/blob/master/CONTRIBUTING.md)

## Licence

BSD 3 Clause [see LICENCE file](https://github.com/studioforty9/twilio/blob/master/LICENCE)
