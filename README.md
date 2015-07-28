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

Via the helper method (uses your configuration settings)

```php

$response = Mage::helper('studioforty9_twilio')->sendMesssage($to, $from, $message);

```

Via the model (add your Account ID and Auth Token manually)

```php

//$sms = new Studioforty9_Twilio_Model_Sms(array('accountId' => $accountId, 'authToken' => $authToken));
$sms = Mage::getModel('studioforty9_twilio/sms', array(
    'accountId' => $accountId, 
    'authToken' => $authToken
));

$response = $sms->setTo('+12345678901')
  ->setFrom('+12345678901')
  ->setBody('Your message')
  ->send();

```

> Media SMS is currently unsupported.

## Contributing

[see CONTRIBUTING file](https://github.com/studioforty9/twilio/blob/master/CONTRIBUTING.md)

## Licence

BSD 3 Clause [see LICENCE file](https://github.com/studioforty9/twilio/blob/master/LICENCE)
