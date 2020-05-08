# Engagespot PHP SDK V2

Easiest way to implement user-specific web push notifications in PHP.

Engagespot helps you to add push notification functionality to your PHP web application (Supports Core PHP as well as frameworks including Laravel, Yii, Symphony etc). Before using this SDK, you need to create a free account at https://engagespot.co

Add push notifications to your web app in less than 10 mins!

### Version
2.0

### Installation

First, you have to get your Site Key and API Key by creating a free web push notification account from Engagespot. You can create your free web push notification account here - https://app.engagespot.co/register

After that, follow the instructions below.

Via Composer

```sh
composer require engagespot/engagespot-php-sdk
```

If you donot want to use composer, you can load the autoload.php file directly.

```sh
require '/path/to/autoload.php';
```

Use the EngagespotPush Class from Engagespot namespace.
Initialize the SDK using your SITE_KEY and API_KEY.
You can find your keys on your Engagespot Dashboard -> Website Settings.

```
use \Engagespot\EngagespotPush;

EngagespotPush::initialize('SITE_KEY','API_KEY');
?>
```

### Sending Push Notification

To send a push notification to all subscribers.

```sh
<?php

$data = ["campaignName" => "Test Campaign",
"title" => "From SDK", 
"message" => "This is from SDK!", 
"link" => "http://someurl.com", 
"icon" => "http://engagespot.co/logo.png"];

EngagespotPush::setMessage($data);
EngagespotPush::send();

?>
```

### Sending Push to identifiers

If you want to send notification selected identifiers (that you have already mapped through Javascript SDK) call addIdentifiers() method before calling send()

```sh
<?php

EngagespotPush::addIdentifiers(array("id1", "id2"));

?>
```
