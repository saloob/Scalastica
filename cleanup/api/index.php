<?php
/**
 * API framework front controller.
 * 
 * @package api-framework
 * @author  Martin Bean <martin@martinbean.co.uk>
 */

/**
 * Generic class autoloader.
 * 
 * @param string $class_name
 */

require ("common.php");

function autoload_class($class_name) {
    $directories = array(
        'classes/',
        'classes/controllers/',
        'classes/models/'
    );
    foreach ($directories as $directory) {
        $filename = $directory . $class_name . '.php';
        if (is_file($filename)) {
            require($filename);
            break;
        }
    }
}

/**
 * Register autoloader functions.
 */
spl_autoload_register('autoload_class');

/**
 * Parse the incoming request.
 */
$request = new Request();
if (isset($_SERVER['PATH_INFO'])) {
    $request->url_elements = explode('/', trim($_SERVER['PATH_INFO'], '/'));
}
$request->method = strtoupper($_SERVER['REQUEST_METHOD']);
switch ($request->method) {
    case 'GET':
        $request->parameters = $_GET;
    break;
    case 'POST':
        $request->parameters = $_POST;
    break;
    case 'PUT':
        parse_str(file_get_contents('php://input'), $request->parameters);
    break;
}

/**
 * Route the request.
 */
if (!empty($request->url_elements)) {

   $controller_name = ucfirst($request->url_elements[0]) . 'Controller';

   if (class_exists($controller_name)) {

      # Call the controller

      $controller = new $controller_name;
      $action_name = strtolower($request->method);

      $response_str = call_user_func_array(array($controller, $action_name), array($request));

      } else {

      header('HTTP/1.1 404 Not Found');
      $response_str = 'Unknown request: ' . $request->url_elements[0];

      }  # class doesn't exist

   } else {

   # Empty request
   #show API contents
    $directories = array(
        'classes/controllers/'
    );

    $api_description = "Welcome to Scalastica API! If you are reading this, then you have not posted or requested anything from our API. The following is a list of the modules you may call from your service;";

    $response_str = array();
    $response_str['api'] = 'Scalastica';
    $response_str['description'] = $api_description;

    $modules = array();

    foreach ($directories as $directory) {

            #echo "Directory: ".$directory."\nn";

            $files = scandir($directory);

            foreach ($files as $file) {

                    $module = str_replace('Controller.php','',$file);

                    if ($module != $file && $module != 'Abstract'){

                       # Stripped out - must be a controller
                       $module = strtolower($module);
                       $modules[] = $module;

                      } #if

                    } # foreach files

            } # foreach directory

    $response_str['modules'] = $modules;
    #serialize($articles)

   } # end if not/empty

/**
 * Send the response to the client.
 */

$response_obj = Response::create($response_str, $_SERVER['HTTP_ACCEPT']);
$final_response = $response_obj->render();
$final_response = mb_convert_encoding($final_response, "UTF-8", "AUTO");
echo $final_response;