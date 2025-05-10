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


define("CIBLES_OBJECTIFS", ["Client", "Prospect", "Taux de Conversion"]);
define("APP_NAME", "GCPCollector");

define("PROFESSIONS", [
    "Commerçant",
    "Entrepreneur",
    "Cadre",
    "Employé",
    "Étudiant",
    "Retraité",
    "Autre"
]);

define("PRODUITS_BANQUES", [
    "Épargne",
    "Investissement",
    "Crédit",
    "Assurance",
    "Gestion de patrimoine"
]);

define('FILTER_PRODUIT', 'filter_produit');
define('FILTER_DATE_DEBUT', 'filter_dateDebut');
define('FILTER_DATE_FIN', 'filter_dateFin');
define('FILTER_PROFESSION', 'filter_profession');
define('FILTER_ID_AGENCE', 'filter_idAgence');
define('FILTER_ID_AGENT', 'filter_idAgent');
define('FILTER_ID_CAMPAGNE', 'filter_idCampagne');