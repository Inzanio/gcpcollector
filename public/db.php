<?php
require __DIR__ . '/vendor/autoload.php';
use Kreait\Firebase\Factory;

$GOOGLE_APPLICATION_CREDENTIALS = "./application_default_credentials.json";

$factory = (new Factory())
     ->withServiceAccount($GOOGLE_APPLICATION_CREDENTIALS);
  

// $auth = $factory->createAuth();
// $realtimeDatabase = $factory->createDatabase();
// $cloudMessaging = $factory->createMessaging();
// $remoteConfig = $factory->createRemoteConfig();
// $cloudStorage = $factory->createStorage(); 
$firestore = $factory->createFirestore();
$database = $firestore->database();

?>