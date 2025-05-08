<?php
// Rôles utilisateurs
define('ROLE_AGENT', 'agent');
define('ROLE_SUPERVISEUR', 'superviseur');
define('ROLE_ADMIN', 'admin');
define('FIREBASE_CREDENTIALS_PATH', '../application_default_credentials.json');
define("DATE_FORMAT", "Y-m-d H:i:s");
define("DATE_FORMAT_SIMPLE_DISPLAY", "l d");
define("FIRESTORE_DATE_FORMAT", "Y-m-d\TH:i:s.u\Z");
define("REGEXP_FIRESTORE_TIMESTAMP", '/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}:\d{2}\.\d{6}Z$/');


define("CIBLES_OBJECTIFS",["Client","Prospect","Taux de Conversion"]);
