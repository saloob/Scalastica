<?php
######################################
# Global Settings File

$synchkey = $portal_config['portalconfig']['synchkey'];
$glb_domain = $portal_config['portalconfig']['glb_domain'];
$glb_home_url = $portal_config['portalconfig']['glb_home_url'];
$glb_app_dir = $portal_config['portalconfig']['glb_app_dir'];
$is_subdomain = $portal_config['portalconfig']['is_subdomain'];
$subdomain = $portal_config['portalconfig']['subdomain'];
$is_ssl = $portal_config['portalconfig']['is_ssl'];
$default_lingo = $portal_config['portalconfig']['default_lingo'];
$portal_email = $portal_config['portalconfig']['portal_email'];
$portal_email_password = $portal_config['portalconfig']['portal_email_password'];
$portal_title = $portal_config['portalconfig']['portal_title'];
$portal_skin = $portal_config['portalconfig']['portal_skin'];
$portal_style = $portal_config['portalconfig']['portal_style'];
$portal_system_style = $portal_config['portalconfig']['portal_system_style'];
$portal_style_images = $portal_config['portalconfig']['portal_style_images'];
$portal_logo = $portal_config['portalconfig']['portal_logo'];
$portal_logo_height = $portal_config['portalconfig']['portal_logo_height'];
$portal_logo_width = $portal_config['portalconfig']['portal_logo_width'];
$portal_logo_title = $portal_config['portalconfig']['portal_logo_title'];
$portal_url  = $portal_config['portalconfig']['portal_url'];
$portal_url_title = $portal_config['portalconfig']['portal_url_title'];
$portal_copyright_text = $portal_config['portalconfig']['portal_copyright_text'];
$portal_copyright_url = $portal_config['portalconfig']['portal_copyright_url'];

$glb_root = "/var/www/vhosts";
//$glb_raw_dir = $glb_root."/".$glb_domain;
$glb_raw_dir = $glb_root."/default";

if ($is_ssl == 1){
   $httpdocs = "httpsdocs";
//   $httpdocs = "htdocs";
   $http = "https";
   } else {
   $httpdocs = "httpdocs";
//   $httpdocs = "htdocs";
   $http = "http";
   }

if ($glb_app_dir != NULL){
   $glb_app_dir = "/".$glb_app_dir."/";
   } else {
   $glb_app_dir = "/";
   }

if ($is_subdomain == 1){
   $glb_doc_root = $glb_root."/".$glb_domain."/subdomains/".$subdomain."/".$httpdocs.$glb_app_dir;
   $glb_home_url = $http."://".$subdomain.".".$glb_domain.$glb_app_dir;
   $root = $glb_root."/".$glb_domain."/subdomains/".$subdomain."/".$httpdocs.$glb_app_dir;
   $home_url = $http."://".$subdomain.".".$glb_domain.$glb_app_dir;
   } else {
   $glb_doc_root = $glb_root."/".$glb_domain."/".$httpdocs.$glb_app_dir;
//   $glb_doc_root = $glb_root."/default/".$httpdocs.$glb_app_dir;
   $glb_home_url = $http."://".$glb_domain.$glb_app_dir;
   $root = $glb_root."/".$glb_domain."/".$httpdocs.$glb_app_dir;
   $home_url = $http."://".$glb_domain.$glb_app_dir;
   }


/*

Requirements for this system

1: ImageMagik for creating thumbnails
2: Web User accounts and basedir access rights
   Using Plesk, add a new web user, like: saloob_1 <- This number should be same as new biz ID
   Add an "Upload" folder inside web user
3:

*/

// Global Variables

// Site Details
$glb_portal_name = "contents";
$glb_portal_id = "11";

// EMail Extraction Info

$glb_host = $glb_domain;
$glb_user = "m@saloob.com";
$glb_pass = "xxxxxx";

// Content Album Info
$glb_url = $glb_domain;
$glb_app_dir = $glb_app_dir;
$glb_content_dir = "content";
$glb_raw_dir = $glb_raw_dir."/";
$glb_home_dir = "/var/www/vhosts/".$glb_url."/httpdocs".$glb_app_dir;
$glb_home_url = "http://www.".$glb_url.$glb_app_dir;
$glb_file_dir = $glb_home_dir.$glb_content_dir;
$glb_file_url = "http://www.".$glb_host.$glb_app_dir.$glb_content_dir;

// SRC Directories
$glb_ftp_server = "timemappers.com";
$glb_dest_dir = $glb_home_dir."en/";
$glb_src_dir = $glb_doc_root."/content/";
$glb_ftp_user_name = "saloob";
$glb_ftp_dir = $glb_src_dir;
$glb_user_url = "http://www.".$glb_url."/~".$glb_ftp_user_name;
$glb_home_ftp_url = $glb_ftp_server;
$glb_home_ftp_dir = "Upload";
$glb_user_url1 = "ftp://".$glb_ftp_user_name;
$glb_user_url2 = ":";
$glb_user_url3 = "@".$glb_domain."/m/".$glb_home_ftp_dir;
$glb_home_ftp_url = $glb_domain;
$glb_user_url = $glb_domain."/~".$glb_ftp_user_name;


// Value for PPV
$glb_usyenrate = "120.23";
$glb_yen_chunk = "2";
$glb_expire_length = "15";
$glb_monthly_length = "30";
$glb_initial_token = "25000";
$glb_initial_fsize = "1";

$glb_newmember_pool[0] = 0.2;
$glb_newmember_pool[1] = 0;

$glb_charge_pool[0] = 0.4;
$glb_charge_pool[1] = 0;
$glb_charge_pool[2] = 0.4;
$glb_charge_pool[3] = 0;
$glb_charge_value = "22";

$glb_ppv_zaspice_rate = 0.5;


// Content
$glb_allowed = array (".gif",".jpeg",".JPG", ".JPEG", ".jpg", ".png", ".bmp", ".mpeg", ".MPEG", ".avi", ".mp3", ".mp4", ".amc", ".wav", ".mov");

$glb_allowed_images = array (".gif",".jpeg",".JPG", ".JPEG", ".jpg", ".png", ".bmp");

$glb_allowed_video = array (".mpeg", ".MPEG", ".avi", ".mp3", ".mp4", ".amc", ".wav");

// Mobile Email Domains
$glb_mobile_emails = array ("jp-a.ne.jp", "jp-b.ne.jp", "jp-c.ne.jp", "jp-d.ne.jp", "jp-e.ne.jp", "jp-f.ne.jp", "jp-g.ne.jp", "jp-h.ne.jp", "jp-i.ne.jp", "jp-j.ne.jp", "jp-k.ne.jp", "jp-l.ne.jp", "jp-m.ne.jp", "jp-n.ne.jp", "jp-o.ne.jp", "jp-p.ne.jp", "jp-q.ne.jp", "jp-r.ne.jp", "jp-s.ne.jp", "jp-t.ne.jp", "jp-u.ne.jp", "jp-v.ne.jp", "jp-w.ne.jp", "jp-x.ne.jp", "jp-y.ne.jp", "jp-z.ne.jp", "docomo.ne.jp", "ezweb.ne.jp", "ido.ne.jp", "a.vodafone.ne.jp", "b.vodafone.ne.jp", "c.vodafone.ne.jp", "d.vodafone.ne.jp", "e.vodafone.ne.jp", "f.vodafone.ne.jp", "g.vodafone.ne.jp", "h.vodafone.ne.jp", "i.vodafone.ne.jp", "j.vodafone.ne.jp", "k.vodafone.ne.jp", "l.vodafone.ne.jp", "m.vodafone.ne.jp", "n.vodafone.ne.jp", "o.vodafone.ne.jp", "p.vodafone.ne.jp", "q.vodafone.ne.jp", "r.vodafone.ne.jp", "s.vodafone.ne.jp", "t.vodafone.ne.jp", "u.vodafone.ne.jp", "v.vodafone.ne.jp", "w.vodafone.ne.jp", "x.vodafone.ne.jp", "y.vodafone.ne.jp", "z.vodafone.ne.jp", "a.softbank.ne.jp", "b.softbank.ne.jp", "c.softbank.ne.jp", "d.softbank.ne.jp", "e.softbank.ne.jp", "f.softbank.ne.jp", "g.softbank.ne.jp", "h.softbank.ne.jp", "i.softbank.ne.jp", "j.softbank.ne.jp", "k.softbank.ne.jp", "l.softbank.ne.jp", "m.softbank.ne.jp", "n.softbank.ne.jp", "o.softbank.ne.jp", "p.softbank.ne.jp", "q.softbank.ne.jp", "r.softbank.ne.jp", "s.softbank.ne.jp", "t.softbank.ne.jp", "u.softbank.ne.jp", "v.softbank.ne.jp", "w.softbank.ne.jp", "x.softbank.ne.jp", "y.softbank.ne.jp", "z.softbank.ne.jp", "softbank.ne.jp", "sms.3rivers.net", "paging.acswireless.com", "advantagepaging.com", "myairmail.com", "alphapage.airtouch.com", "airtouch.net", "airtouchpaging.com", "alphanow.net", "message.alltel.com", "message.alltel.com", "paging.acswireless.com", "pageapi.com", "page.americanmessaging.net", "clearpath.acswireless.com", "airtelap.com", "archwireless.net", "epage.arch.com", "archwireless.net", "txt.att.net", "mmode.com", "mobile.att.net", "dpcs.mobile.att.net", "beepwear.net", "sms.beemail.ru", "message.bam.com", "txt.bellmobility.ca", "bellmobility.ca", "txt.bell.ca", "txt.bellmobility.ca", "bellsouthtips.com", "sms.bellsouth.com", "wireless.bellsouth.com", "blsdcs.net", "bellsouth.cl", "blsdcs.net", "blueskyfrog.com", "sms.bluecell.com", "myboostmobile.com", "bplmobile.com", "cwwsms.com", "cmcpaging.com", "phone.cellone.net", "swmsg.com", "paging.cellone-sf.com", "mobile.celloneusa.com", "cellularone.txtmsg.com", "cellularone.textmsg.com", "cell1.textmsg.com", "message.cellone-sf.com", "sbcemail.com", "mycellone.com", "csouth1.com", "cwemail.com", "cvcpaging.com", "messaging.centurytel.net", "rpgmail.net", "airtelchennai.com", "gocbw.com", "mycingular.com", "mycingular.net", "mms.cingularme.com", "page.cingular.com", "cingularme.com", "mycingular.textmsg.com", "mobile.mycingular.com", "mobile.mycingular.net", "msg.clearnet.com", "comcastpcs.textmsg.com", "pageme.comspeco.net", "pager.comspeco.com", "sms.comviq.se", "cookmail.com", "corrwireless.net", "airtelmail.com", "delhi.hutch.co.in", "page.hit.net", "mobile.dobson.net", "mobile.cellularone.com", "t-mobile-sms.de", "sms.orange.nl", "sms.edgewireless.com", "sms.emt.ee", "escotelmobile.com", "fido.ca", "epage.gabrielwireless.com", "sendabeep.net", "webpager.us", "t-mobile-sms.de", "bplmobile.com", "sms.goldentele.com", "epage.porta-phone.com", "airmessage.net", "gte.pagegate.net", "messagealert.com", "celforce.com", "messaging.sprintpcs.com", "text.houstoncellular.net", "ideacellular.net", "ivctext.com", "page.infopagesystems.com", "inlandlink.com", "pager.tdspager.com");

$glb_mobile_phones = array ("DoCoMo", "L-mode", "ASTEL", "UP.Browser", "PDXGW", "J-PHONE", "KDDI", "SoftBank", "sony", "symbian", "nokia", "samsung", "mobile", "windows ce", "epoc", "opera mini", "nitro", "j2me", "midp-", "cldc-", "netfront", "mot", "up.browser", "up.link", "audiovox", "blackberry", "ericsson,", "panasonic", "philips", "sanyo", "sharp", "sie-", "portalmmm", "blazer", "avantgo", "danger", "palm", "series60", "palmsource", "pocketpc", "smartphone", "rover", "ipaq", "au-mic,", "alcatel", "ericy", "up.link", "vodafone", "wap1.", "wap2.");

// Thumb and Video Conversions

$glb_chowner = "timemappersftp.psacln";
$glb_images_per_page = "7";
$glb_thumb_width = "144";
$glb_flv_thumb_width = "144";
$glb_flv_thumb_height = "108";
$glb_flv_thumb_time = "10";
$glb_picture_width = "400";
//$glb_maxpopsize = "1683456";
$glb_maxpopsize = 5683456;
$glb_maxthumb = 100000; //100KB
$glb_maxsize = 10000000; //100KB
$glb_perpage_thumbs = "12";
$glb_thumb_columns = "3";

$glb_jump = "top.php";
$glb_content_page = "Content.php";

$glb_maxline = 500;

$glb_maxbyte = 100000000; //10000KB

$glb_maxtext = 100000;

$glb_deny = array('163.com','bigfoot.com','boss.com');

$glb_nosubject = "NO SUBJECT";

# End Global Settings File
######################################
?>