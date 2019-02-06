<?php 
##############################################
# Scalastica
# Author: Matthew Edmond, Saloob
# Date: 2014-12-08
# Page: api.php 
##########################################################
# case 'API':

    $params = array();
    $parts = explode('/', $_SERVER['REQUEST_URI']);

    #$endpoint = array_shift($parts);

    #echo "Server Name :".$_SERVER['SERVER_NAME']."<P>";
    #echo "Endpoint :".$endpoint."<P>";

    for ($i = 0; $i < count($parts); $i = $i + 2){
        //first segment is the param name, second is the value 
        $params[$parts[$i]] = $parts[$i+1];
        if ($parts[$i+1] == 'api.php'){
           $method = $parts[$i+2];
           $verb = $parts[$i+3];
           $val = $parts[$i+4];
           }
        echo "Param: ".$parts[$i]." -> ".$parts[$i+1]."<BR>";
        }

        echo "Method: ".$method.", Verb: ".$verb.", Val: ".$val."<BR>";

#var_dump($params);

exit;

require_once 'api-class.php';
class MyAPI extends API
{
    protected $User;

    public function __construct($request, $origin) {
        parent::__construct($request);

        // Abstracted out for example
        $APIKey = new Models\APIKey();
        $User = new Models\User();

        if (!array_key_exists('apiKey', $this->request)) {
            throw new Exception('No API Key provided');
        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
            throw new Exception('Invalid API Key');
        } else if (array_key_exists('token', $this->request) &&
             !$User->get('token', $this->request['token'])) {

            throw new Exception('Invalid User Token');
        }

        $this->User = $User;
    }

    /**
     * Example of an Endpoint
     */
     protected function nw() {
        if ($this->method == 'GET') {
            return "Your name is " . $this->User->name;
        } else {
            return "Only accepts GET requests";
        }
     }
 }

// Requests from the same server don't have a HTTP_ORIGIN header
if (!array_key_exists('HTTP_ORIGIN', $_SERVER)) {
    $_SERVER['HTTP_ORIGIN'] = $_SERVER['SERVER_NAME'];
}

try {

//    $API = new MyAPI($_REQUEST['request'], $_SERVER['HTTP_ORIGIN']);
    $API = new MyAPI($params, $_SERVER['HTTP_ORIGIN']);
    echo $API->processAPI();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

# break; // End Activity
##########################################################
?>