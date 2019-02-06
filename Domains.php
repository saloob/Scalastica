<?php

//require_once 'XML/lib/xmlrpc.php';

#$xml_rpc_host = "93.190.235.176:8081";

# s_entity stands for the system intance
# s_entity=1234 reflects the OT&E system whereas
# s_entity=54cd reflects the LIVE system

#$command["s_entity"] = "1234";
#$command["domain"] = "farmplayer.com";
# saloob!1


/*
$params = array(XML_RPC_encode($command));
$msg = new XML_RPC_Message('Api.xcall', $params);
$client = new XML_RPC_Client($xml_rpc_uri, $xml_rpc_host, $xml_rpc_port);
#$client->setDebug(1);
$response = $client->send($msg);
$v = XML_RPC_decode($response->value());
echo "<pre>"; print_r($v); echo "</pre>";
if ($response->faultCode()) {
 // Error-Handling
}
// ...
*/
        $time_start = date('Y-m-d H:i:s');
        echo "<P>Time - Start: ".$time_start."<P>";

        $reloop = "FALSE";
        $syno == "FALSE";
        #$keyword = "running";
        $action = $_GET["action"];
        $syno = $_GET["syno"];
        $tlds = $_GET["tlds"];
        $reloop = $_GET["reloop"];
        $keyword = $_GET["keyword"];
        #$tlds = array(".com",".net",".co",".de",".ch",".name",".jp");
        $tlds = explode("[]",$tlds);
        #$tlds = array(".jp");
        sort($tlds);

        #$domainavail = domcheck ($keyword.".com");
        #print $keyword.": ".$domainavail['DESCRIPTION']."<BR>";

function synonymiser ($word){

        $the_version = "2";
        $the_api_key = "940dc4e7f0012570aad56d02d4d9cb9d";
        $the_format = "json";
        $thesaurus_url = "http://words.bighugelabs.com/api/".$the_version."/".$the_api_key."/".$word."/".$the_format;

        $ch = curl_init($thesaurus_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $wordlist = json_decode($response, TRUE);

        #var_dump($wordlist);

        $noun = $wordlist["noun"];
        $adjective = $wordlist["adjective"];
        $verb = $wordlist["verb"];

        if (is_array($noun)){
        #echo "Noun:".$noun;
           $wordsyns = $noun["syn"];
           } elseif (is_array($adjective)) {
           $wordsyns = $adjective["syn"];
           } elseif (is_array($verb)) {
           $wordsyns = $verb["syn"];
           }

        #echo "Noun Syns:".$nounsyns;

  return $wordsyns;

} # end synonymiser

        $synonyms = array();
        $finalsynonyms = array();

        # First round to get first synonyms
        if ($keyword != NULL && $action == "CheckDomain"){

           $finalsynonyms[0] = $keyword;

           if ($syno == "TRUE"){

              #$time_syns_start = date('Y-m-d H:i:s');
              #echo "<P>Time - Syns Start: ".$time_syns_start."<P>";

              $syn_cache_file = "/tmp/cache_synonyms_".$keyword;

              if (!file_exists($left_cache_file)){
                 $synonyms = synonymiser ($keyword);
                 if (!is_array($synonyms)){
                    $synonyms[0] = $keyword;
                    } else {
                    #array_push($synonyms,$keyword);
                    } 

                 $serialized = serialize($synonyms);
                 file_put_contents($syn_cache_file, $serialized);

                 } else {# if no file

                 $serialized = file_get_contents($syn_cache_file);
                 $synonyms = unserialize($serialized);

                 } # synfile

              #$time_syns_end = date('Y-m-d H:i:s');
              #echo "<P>Time - Syns End: ".$time_syns_end."<P>";

              $finalsynonyms = array_merge($finalsynonyms,$synonyms);
              #echo "<P>First synonyms<P>";
              #print_r($synonyms);

              if ($reloop == "TRUE"){

                 #$time_synsreloop_start = date('Y-m-d H:i:s');
                 #echo "<P>Time - Syns Reloop Start: ".$time_synsreloop_start."<P>";

                 $reloop_syn_cache_file = "/tmp/cache_synonyms_reloop_".$keyword;

                 if (!file_exists($reloop_syn_cache_file)){

                    for ($syni = 0; $syni < count($synonyms); ++$syni) {
                        $synonym = $synonyms[$syni];
                        #echo "<P>Synonym: ".$synonym."<P>";
                        $newsynonyms = synonymiser ($synonym);
                        #echo "<P>New synonyms from ".$synonym."<P>";
                        #print_r($newsynonyms);
                        #array_merge($finalsynonyms,$newsynonyms);
                        if (is_array($newsynonyms)){
                           $finalsynonyms = array_merge($finalsynonyms,$newsynonyms);
                           }
                        #$finalsynonyms = $finalsynonyms+$newsynonyms;
                        }

                    $reloop_serialized = serialize($finalsynonyms);
                    file_put_contents($reloop_syn_cache_file, $reloop_serialized);

                    } else {

                    $reloop_serialized = file_get_contents($reloop_syn_cache_file);
                    $finalsynonyms = unserialize($reloop_serialized);
   
                    } #

                  #$time_synsreloop_end = date('Y-m-d H:i:s');
                  #echo "<P>Time - Syns Reloop End: ".$time_synsreloop_end."<P>";

                  } # reloop

              } # if syn

           #echo "<P>Final synonyms<P>";
           #print_r($finalsynonyms);

           $wordsyns = array_unique($finalsynonyms);
           sort($wordsyns);

           #echo "<P>Final unique synonyms<P>";
           #print_r($wordsyns);

           echo "<P><B>Get Domain Availability</B><P>";
           echo "If a domain is available, we cache the data for one hour - it means someone has checked it!!<P><hr><P>";

           #exit;
           # 1 hour
           # 1 day - 24 hours
           # 7 days - 168 hours
           # 365 days - 8760 hours
           # 182 days - 4380 hours - days since recorded as registered - should check actual rego/expiry date of domain 

           $cache_time = 4380; # hour
           $availcache_time = 12; # hour

           for ($i = 0; $i < count($wordsyns); ++$i) {

               if ($wordsyns[$i] != str_replace(" ","-",$wordsyns[$i])){

                  for ($tldi = 0; $tldi < count($tlds); ++$tldi) {
                      $domain = str_replace(" ","-",$wordsyns[$i]);

                      $totaldoms++;

                      $tld = $tlds[$tldi];
                      $domain = $domain.$tld;

                      $domain_cache_file = "/tmp/domains/".$domain;
                      $domain_avail_cache_file = "/tmp/domains/avail/".$domain;

                      #if (!file_exists($domain_cache_file)){
                      #if (!file_exists($domain_cache_file) || (filemtime($domain_cache_file) < time() - $cache_time * 3600)){
                      if ((!file_exists($domain_cache_file) || (filemtime($domain_cache_file) < (time() - ($cache_time * 3600)))) && (!file_exists($domain_avail_cache_file) || (filemtime($domain_avail_cache_file) < (time() - ($availcache_time * 3600))))) {

                         # use filetime if wanted to check all domains
                         #$domain_filetime = filemtime($domain_cache_file);
                         #echo "Filetime: ".$domain_filetime."<P>";
                         #$calctime = time();
                         #$calc = time() - ($cache_time * 3600);
                         #echo "Calc: ".$calc."<P>";
                         #$calcdiff = domain_filetime-$calc;

                         #echo $domain_filetime." < ".$calctime." - ".$cache_time."*3600<P>";
                         #echo $domain_filetime." < ".$calc."<P>";
                         #echo "Calcdiff: ".$calcdiff."<P>";

                         if (file_exists($domain_avail_cache_file)){

                            $domain_avail_time = filemtime($domain_avail_cache_file);
                            #echo "Filetime: ".$domain_avail_time."<P>";
                            #$calctime = time();
                            #$calc = time() - ($availcache_time * 3600);
                            #echo "Calc: ".$calc."<P>";
                            #$calcdiff = $calc - filemtime($domain_avail_cache_file);
                            #echo "Calcdiff: ".$calcdiff."<P>";
                            #echo $domain_avail_time." < ".$calctime." - ".$availcache_time."*3600<P>";
                            #echo $domain_avail_time." < ".$calc."<P>";

                            $domain_avail_time = date ("Y-m-d h:i:s ", $domain_avail_time);
                            echo "<P><font color=red>Available $domain already checked by someone @ ".$domain_avail_time."</font><P>";

                            } 

                         $time_calldomain = date('Y-m-d H:i:s');
                         echo "<P>Check $domain (Time: ".$time_calldomain.")<P>";

                         $domain_action = "CheckDomain";
                         $domainpack[0] = $domain;
                         $domainpack[1] = $domain_action;

                         $domainavail = domcheck ($domainpack);

                         # Only cache domains that are NOT available - no point checking them
                         if ($domainavail['CODE'] == 211){

                            $domain_serialized = serialize($domainavail);
                            file_put_contents($domain_cache_file, $domain_serialized);

                            } else {

                            $domain_serialized = serialize($domainavail);
                            file_put_contents($domain_avail_cache_file, $domain_serialized);
   
                            $dompack[] = $domain;

                            }

                         } else {

                         if (file_exists($domain_avail_cache_file)){
                            $domaincachefile = $domain_avail_cache_file;
                            } else {
                            $domaincachefile = $domain_cache_file;
                            }

                         $filemtime = filemtime($domaincachefile);
                         $showfilemtime = date ("Y-m-d h:i:s ", $filemtime);
                         echo "<P><font color=red>Available $domain already checked by someone @ ".$showfilemtime."</font><P>";

                         $domain_serialized = file_get_contents($domaincachefile);
                         $domainavail = unserialize($domain_serialized);

                         $dompack[] = $domain;

                         } 

                      if ($domainavail['CODE'] == 210){
                         $available++;
                         $colour = "BLUE";
                         $link = " [Get!] ";
                         } else {
                         $colour = "RED";
                         $link = " [<a href=http://www.".$domain." target=Domain>Go!!</a>] ";
                         } 

                      print $link."<font color=".$colour.">".$domain.": ".$domainavail['CODE']." - ".$domainavail['DESCRIPTION']."</font><P><hr><P>";

                      flush();

                      } # for

                  for ($tldi = 0; $tldi < count($tlds); ++$tldi) {

                      $domain = str_replace(" ","",$wordsyns[$i]);

                      $totaldoms++;

                      $tld = $tlds[$tldi];
                      $domain = $domain.$tld;

                      $domain_cache_file = "/tmp/domains/".$domain;
                      $domain_avail_cache_file = "/tmp/domains/avail/".$domain;

                      #if (!file_exists($domain_cache_file)){
                      #if (!file_exists($domain_cache_file) || (filemtime($domain_cache_file) < time() - $cache_time * 3600)){
                      if ((!file_exists($domain_cache_file) || (filemtime($domain_cache_file) < (time() - ($cache_time * 3600)))) && (!file_exists($domain_avail_cache_file) || (filemtime($domain_avail_cache_file) < (time() - ($availcache_time * 3600))))) {

                         if (file_exists($domain_avail_cache_file)){
                            $domain_avail_time = filemtime($domain_avail_cache_file);
                            $domain_avail_time = date ("Y-m-d h:i:s ", $domain_avail_time);
                            echo "<P><font color=red>Available $domain already checked by someone @ ".$domain_avail_time."</font><P>";
                            }

                         $time_calldomain = date('Y-m-d H:i:s');
                         echo "<P>Check $domain (Time: ".$time_calldomain.")<P>";

                         $domain_action = "CheckDomain";
                         $domainpack[0] = $domain;
                         $domainpack[1] = $domain_action;

                         $domainavail = domcheck ($domainpack);

                         # Only cache domains that are NOT available - no point checking them
                         if ($domainavail['CODE'] == 211){
                            $domain_serialized = serialize($domainavail);
                            file_put_contents($domain_cache_file, $domain_serialized);
                            } else {
                            $domain_serialized = serialize($domainavail);
                            file_put_contents($domain_avail_cache_file, $domain_serialized);

                            $dompack[] = $domain;

                            }

                         } else {

                         if (file_exists($domain_avail_cache_file)){
                            $domaincachefile = $domain_avail_cache_file;
                            } else {
                            $domaincachefile = $domain_cache_file;
                            }

                         $filemtime = filemtime($domaincachefile);
                         $showfilemtime = date ("Y-m-d h:i:s ", $filemtime);
                         echo "<P><font color=red>Available $domain already checked by someone @ ".$showfilemtime."</font><P>";

                         $domain_serialized = file_get_contents($domaincachefile);
                         $domainavail = unserialize($domain_serialized);

                         $dompack[] = $domain;

                         } 

                      if ($domainavail['CODE'] == 210){
                         $colour = "BLUE";
                         $available++;
                         $link = " [Get!] ";
                         } else {
                         $colour = "RED";
                         $link = " [<a href=http://www.".$domain." target=Domain>Goto</a>] ";
                         } 

                      print $link."<font color=".$colour.">".$domain.": ".$domainavail['CODE']." - ".$domainavail['DESCRIPTION']."</font><P><hr><P>";

                      flush();

                      } # for

                  } else {

                  for ($tldi = 0; $tldi < count($tlds); ++$tldi) {

                      $domain = $wordsyns[$i];

                      $totaldoms++;

                      $tld = $tlds[$tldi];
                      $domain = $domain.$tld;

                      $domain_cache_file = "/tmp/domains/".$domain;
                      $domain_avail_cache_file = "/tmp/domains/avail/".$domain;

                      #if (!file_exists($domain_cache_file)){
                      if ((!file_exists($domain_cache_file) || (filemtime($domain_cache_file) < (time() - ($cache_time * 3600)))) && (!file_exists($domain_avail_cache_file) || (filemtime($domain_avail_cache_file) < (time() - ($availcache_time * 3600))))) {

                         if (file_exists($domain_avail_cache_file)){
                            $domain_avail_time = filemtime($domain_avail_cache_file);
                            $domain_avail_time = date ("Y-m-d h:i:s ", $domain_avail_time);
                            echo "<P><font color=red>Available $domain already checked by someone @ ".$domain_avail_time."</font><P>";
                            }

                         $time_calldomain = date('Y-m-d H:i:s');
                         echo "<P>Check $domain (Time: ".$time_calldomain.")<P>";

                         $domain_action = "CheckDomain";
                         $domainpack[0] = $domain;
                         $domainpack[1] = $domain_action;

                         $domainavail = domcheck ($domainpack);

                         # Only cache domains that are NOT available - no point checking them
                         if ($domainavail['CODE'] == 211){
                            $domain_serialized = serialize($domainavail);
                            file_put_contents($domain_cache_file, $domain_serialized);
                            } else {
                            $domain_serialized = serialize($domainavail);
                            file_put_contents($domain_avail_cache_file, $domain_serialized);

                            $dompack[] = $domain;

                            }

                         } else {

                         if (file_exists($domain_avail_cache_file)){
                            $domaincachefile = $domain_avail_cache_file;
                            } else {
                            $domaincachefile = $domain_cache_file;
                            }

                         $filemtime = filemtime($domaincachefile);
                         $showfilemtime = date ("Y-m-d h:i:s ", $filemtime);
                         echo "<P><font color=red>Available $domain already checked by someone @ ".$showfilemtime."</font><P>";

                         $domain_serialized = file_get_contents($domaincachefile);
                         $domainavail = unserialize($domain_serialized);

                         $dompack[] = $domain;

                         } 

                      if ($domainavail['CODE'] == 210){
                         $available++;
                         $colour = "BLUE";
                         $link = " [Get!] ";
                         } else {
                         $colour = "RED";
                         $link = " [<a href=http://www.".$domain." target=Domain>Goto</a>] ";
                         } 

                      print $link."<font color=".$colour.">".$domain.": ".$domainavail['CODE']." - ".$domainavail['DESCRIPTION']."</font><P><hr><P>";

                      flush();

                      } # for

                  } # if space

               flush();

               } # for


           #$dompack = $dompack; # Actual domains

           for ($i = 0; $i < count($dompack); ++$i) {
               
               $domwords .= $dompack[$i]." ";
           
               }

           $total = count($wordsyns);
           $perc = round(100*($available/$totaldoms),2);
           echo "<P>Original Word: ".$keyword."<BR>";
           echo "Total Words: ".$total."<BR>";
           echo "Total Domains: ".$totaldoms."<BR>";
           echo "Total Available Domains: ".$available." (".$perc."%)<P>";

#PBAS Form
#http://forum.odin.com/threads/redirect-customer-from-external-website-with-domain-search-form-to-pbas-store.290668/

?>
<html>
<body>
<script type="text/javascript">
			function adopt_form() {
				var rule_url = document.getElementById('rule_url');
				var form = document.getElementById('do_action');
				form.action = rule_url.value;
				//console.log($('form#do_action').serialize());
				form.submit();
			}
		</script>
<form id="do_action" name="do_action" method="POST" target="_blank" action="">
			<table>
				<tr>
					<td>Rule URL</td>
					<td><input type="text" id="rule_url" name="rule_url" size="50" value="https://hosting.scalastica.com/shop/en/redirect/c_domains" /></td>
				</tr>
				<tr>
					<td>dm_action</td>
					<td>
						<select name="dm_action">
							<option value="register_new">register_new</option>
							<option value="reg_transfer">reg_transfer</option>
							<option value="domain_pointer">domain_pointer</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>domain_selection_type</td>
					<td>
						<select name="domain_selection_type">
							<option value="single">single</option>
							<option value="multi">multi</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>domain_name</td>
					<td><input type="text" name="domain_name" value="<?php echo $keyword; ?>" size="30" /></td>
				</tr>
								<tr>
					<td>domain_names</td>
					<td><textarea name="domain_names" cols="30" rows="7"><?php echo $domwords; ?></textarea></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" value="submit" onclick="adopt_form(); return false;"/></td>
			</table>
		</form> 
</body>
</html>
<?php
           } # if

        if ($keyword != NULL && ($action == "StatusDomain" || $action == "QueryDomainList" || $action == "QueryExtendedDomainList")){

           $domain_action = $action;
           $domainpack[0] = $keyword;
           $domainpack[1] = $domain_action;

           $domain_info = domcheck ($domainpack);

           /*
           $code = $domain_info['CODE'];
           $CREATEDBY = $domain_info['CREATEDBY'];
           $CREATEDDATE = $domain_info['CREATEDDATE'];
           $UPDATEDBY = $domain_info['UPDATEDBY'];
           $UPDATEDDATE = $domain_info['UPDATEDDATE'];
           $REGISTRAR = $domain_info['REGISTRAR'];
           $REGISTRATIONEXPIRATIONDATE = $domain_info['REGISTRATIONEXPIRATIONDATE'];
           $REGISTRARTRANSFERDATE = $domain_info['REGISTRARTRANSFERDATE'];
           $STATUS = $domain_info['STATUS'];
           $OWNERCONTACT = $domain_info['OWNERCONTACT'];
           $ADMINCONTACT = $domain_info['ADMINCONTACT'];
           $TECHCONTACT = $domain_info['TECHCONTACT'];
           $BILLINGCONTACT = $domain_info['BILLINGCONTACT'];
           $NAMESERVER = $domain_info['NAMESERVER'];
           $AUTH = $domain_info['AUTH'];
           $USER = $domain_info['USER'];
           $RENEWALMODE = $domain_info['RENEWALMODE'];
           $TRANSFERMODE = $domain_info['TRANSFERMODE'];
           $RENEWALDATE = $domain_info['RENEWALDATE'];
           */

           var_dump($domain_info);

           } # if

    function domcheck ($domain_pack){

     $domain = $domain_pack[0];
     $action = $domain_pack[1];

# https://wiki.hexonet.net/images/0/01/DOMAIN_API_Reference.pdf
#echo "Domain check: ".$domain."<BR>";

        #$time_dom_start = date('Y-m-d H:i:s');
        #echo "<P>Time Domain $domain - Start: ".$time_dom_start."<P>";

$xml_rpc_host = "http://xmlrpc-api.hexonet.net:8081";
$xml_rpc_port = 8081;
$xml_rpc_uri = "/RPC2";

$command["s_entity"] = "54cd";
$command["s_login"] = "saloob";
$command["s_pw"] = "JimmyHen72";
#$command["command"] = "QueryDomainList";
#$command["command"] = "StatusDomain";
$command["command"] = $action; #"CheckDomain";
$command["domain"] = $domain;

switch ($action){

 case 'QueryDomainList':
 case 'QueryExtendedDomainList':

  $command["userdepth"] = "ALL";

 break;

}

$request = xmlrpc_encode_request("Api.xcall", $command);
$context = stream_context_create(array('http' => array(
    'method' => "POST",
    'header' => "Content-Type: text/xml",
    'content' => $request
)));

   $file = file_get_contents($xml_rpc_host.$xml_rpc_uri, false, $context);
   $response = xmlrpc_decode($file);

if ($response && xmlrpc_is_fault($response)) {
    trigger_error("xmlrpc: $response[faultString] ($response[faultCode])");
    } else {

    #print_r($response);

    $property = $response['PROPERTY']; # array

    $description = $response['DESCRIPTION'];
    $code = $response['CODE'];
    $queuetime = $response['QUEUETIME'];
    $runtime = $response['RUNTIME'];

    #var_dump($property);

    # CheckDomain
    $reason = $property['REASON'][0];
    /*
   Array (
	 [PROPERTY] => Array (
		[REASON] => Array ( [0] => ) 
		)
	 [DESCRIPTION] => Available
	 [QUEUETIME] => 0
	 [CODE] => 210
	 [RUNTIME] => 0.127
	 )
   */

    #$reason = $property['REASON'][0];
    #echo "Code: ".$code."<BR>";
    #echo "Reason: ".$reason."<BR>";
    #echo "Description: ".$description."<BR>";

    #QueryDomainList
    /*
    $total = $property['TOTAL'][0];
    $last = $property['LAST'][0];
    $limit = $property['LIMIT'][0];
    $count = $property['COUNT'][0];
    $first = $property['FIRST'][0];

    echo "Total: ".$total."<BR>";
    echo "Limit: ".$limit."<BR>";
    */

    /*
    [PROPERTY] => Array (
	 [TOTAL] => Array ( [0] => 0 )
	 [LAST] => Array ( [0] => -1 )
	 [LIMIT] => Array ( [0] => 10000 )
	 [COUNT] => Array ( [0] => 0 )
	 [FIRST] => Array ( [0] => 0 )
	 )
    [DESCRIPTION] => Command completed successfully
    [CODE] => 200
    [QUEUETIME] => 0
    [RUNTIME] => 0.007
    */

    } # else

    #$time_dom_end = date('Y-m-d H:i:s');
    #echo "<P>Time Domain $domain - End: ".$time_dom_end."<P>";

    return $response;

 } # end function

?>
