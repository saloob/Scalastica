(function(context) {
    FBHelper = {};
    var ref;
    
    FBHelper.init = function() {
        
        var url = "https://www.sharedeffects.com/api-facebook.php?action=mlogin&source=mobileapp";  
        
        if (this.isPhoneGapApp()) {
           ref = window.open(url, '_blank', 'location=yes');
           ref.addEventListener("loadstart", this.getAccessToken);
        } else {
            window.open(url, "_self");
            
        }
    };   

    
    FBHelper.getAccessToken = function(event) {
        
        if (event.url.indexOf('fb_access_token') >= 0) {
        //if (event.url.indexOf(redirect_url) === 0) {            
            //console.log("Extracting access_token...");
            var vars = parseUrlVars(event.url);
            var _fb_access_token = vars.fb_access_token;
            //var params = event.url.split("fb_access_token=");
            //var _fb_access_token = params[1].slice(0, params[1].indexOf("&"));
            localStorage.setItem('fb_access_token', _fb_access_token);
            ref.close();
            Appery.navigateTo('Facebook_Return', {});
            
        }         
    };
     
    
    FBHelper.isPhoneGapApp = function() {
        return (document.URL.indexOf('http://') === -1 && document.URL.indexOf('https://') === -1);
    };      
    
    if (window.location.href.indexOf("fb_access_token") != -1) {
        var hashFromFb = window.location.hash;
        window.location.hash = '';
        var paramsFromFb = hashFromFb.substring(1).split("&");
        var fb_access_token = paramsFromFb[0].split("=")[1];
        localStorage.setItem('fb_access_token', fb_access_token);        
        
    }
        
    context.FBHelper = FBHelper;
})
(window);

(function(context) {
    GoogleHelper = {};
    var ref;
    
    GoogleHelper.init = function() {
    
        var callbackUrl = "https://www.sharedeffects.com/api-google.php";
        var url = "https://www.sharedeffects.com/api-google.php?action=login&source=mobileapp&redirect_uri=" + callbackUrl + "&scope=&response_type=token";
        if (this.isPhoneGapApp()) {
            ref = window.open(url, '_blank', 'location=yes');
            ref.addEventListener("loadstart", this.getAccessToken);
        } else {
            window.open(url, "_self");
            
        }
    };
    
    GoogleHelper.getAccessToken = function(event) {
        
        if (event.url.indexOf('access_token') >= 0) {
            console.log("Extracting access_token...");
            var params = event.url.split("access_token=");
            var _access_token = params[1].slice(0, params[1].indexOf("&"));
            localStorage.setItem('access_token', _access_token);
            ref.close();
            Appery.navigateTo('Google_Me', {});
            
        }
        
    };
    
    GoogleHelper.isPhoneGapApp = function() {
        return (document.URL.indexOf('http://') === -1 && document.URL.indexOf('https://') === -1);
    };
    
    if (window.location.href.indexOf("access_token") != -1) {
        var hashFromFb = window.location.hash;
        window.location.hash = '';
        var paramsFromFb = hashFromFb.substring(1).split("&");
        var access_token = paramsFromFb[0].split("=")[1];
        localStorage.setItem('access_token', access_token);
        
    }
    
    context.GoogleHelper = GoogleHelper;
})
(window);

(function(context) {
    LinkedInHelper = {};
    var ref;
    
    LinkedInHelper.init = function() {
    
        var callbackUrl = "https://www.sharedeffects.com/api-linkedin.php";
        var url = "https://www.sharedeffects.com/api-linkedin.php?action=login&source=mobileapp&redirect_uri=" + callbackUrl + "&scope=&response_type=token";
        if (this.isPhoneGapApp()) {
            ref = window.open(url, '_blank', 'location=yes');
            ref.addEventListener("loadstart", this.getAccessToken);
        } else {
            window.open(url, "_self");
            
        }
    };
    
    LinkedInHelper.getAccessToken = function(event) {
        
        if (event.url.indexOf('access_token') >= 0) {
            console.log("Extracting access_token...");
            var params = event.url.split("access_token=");
            var _access_token = params[1].slice(0, params[1].indexOf("&"));
            localStorage.setItem('access_token', _access_token);
            ref.close();
            Appery.navigateTo('LinkedIn_Me', {});
            
        }
        
    };
    
    LinkedInHelper.isPhoneGapApp = function() {
        return (document.URL.indexOf('http://') === -1 && document.URL.indexOf('https://') === -1);
    };
    
    if (window.location.href.indexOf("access_token") != -1) {
        var hashFromFb = window.location.hash;
        window.location.hash = '';
        var paramsFromFb = hashFromFb.substring(1).split("&");
        var access_token = paramsFromFb[0].split("=")[1];
        localStorage.setItem('access_token', access_token);
        
    }
    
    context.LinkedInHelper = LinkedInHelper;
})
(window);