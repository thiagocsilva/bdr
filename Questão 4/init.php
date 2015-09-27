<?php
if (!defined('ABSPATH')) {
    throw new Exception('nao foi definido o ABSPATH');
}

//caminhos
define('FOLDER_INC', 'inc');
define('FOLDER_VIEW', 'view');
define('FOLDER_JS', 'js');
define('FOLDER_IMG', 'images');
define('FOLDER_PARTIAL', 'partial');
define('FOLDER_CONFIG', '_configuracao');
define('FOLDER_REPOSITORIES', 'repositories');

define('ABSPATH_JS', ABSPATH . FOLDER_JS);
define('ABSPATH_IMAGE', ABSPATH . FOLDER_IMG);

define('ABSPATH_INC', ABSPATH . FOLDER_INC);
define('ABSPATH_VIEW', ABSPATH . FOLDER_VIEW);
define('ABSPATH_PARTIAL', ABSPATH . FOLDER_PARTIAL);
define('ABSPATH_CONFIG', ABSPATH . FOLDER_CONFIG);
define('ABSPATH_REPOSITORIES', ABSPATH . FOLDER_REPOSITORIES);

//dados para o sistema
define('FORMAT_DATE', 'd-m-Y H:i:s');
date_default_timezone_set('America/Sao_Paulo');

include(ABSPATH_INC . '/Helpers.php');
include(ABSPATH_INC . '/HtmlBuilder.php');
include(ABSPATH_INC . '/Input.php');
include(ABSPATH_INC . '/Response.php');
include(ABSPATH_INC . '/Email.php');
include(ABSPATH_INC . '/Config.php');
include(ABSPATH_INC . '/Cookie.php');
include(ABSPATH_INC . '/Session.php');
include(ABSPATH_INC . '/Format.php');
include(ABSPATH_INC . '/Sanatize.php');
include(ABSPATH_INC . '/Validator.php');
