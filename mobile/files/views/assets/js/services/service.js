/*
 * Service settings
 */
var Facebook_Settings = {
    "client_id": "",
    "project_id": ""
}

/*
 * Services
 */
var DeviceContacts_List = new Apperyio.ContactsService({});

var RESTService_RecipientTypes = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'https://www.sharedeffects.com/api/recipienttypes',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438286',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'get',
});

var Facebook_MeService = new Apperyio.RestService({
    'url': 'https://graph.facebook.com/me',
    'dataType': 'json',
    'type': 'get',

    'serviceSettings': Facebook_Settings
});

var RESTService_Events_post = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'http://www.sharedeffects.com/api/events',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'post',
    'contentType': 'application/x-www-form-urlencoded',
});

var RESTService_Events_list = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'http://www.sharedeffects.com/api/events',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'get',
});

var RESTService_Categories_list = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'https://www.sharedeffects.com/api/categories',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'get',
});
var RESTService_Geolocation = new Apperyio.GeolocationService({});

var Facebook_Allowed = new Apperyio.RestService({
    'url': 'https://www.sharedeffects.com/api/facebook',
    'dataType': 'json',
    'type': 'get',
});

var RESTService_Contacts_list = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'http://www.sharedeffects.com/api/contacts',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'get',
});

var RESTService_Registration = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'http://www.sharedeffects.com/api/auth',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'post',
    'contentType': 'application/x-www-form-urlencoded',
});

var RESTService_Messages_post = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'https://www.sharedeffects.com/api/messages',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'post',
    'contentType': 'application/x-www-form-urlencoded',
});

var RESTService_Auth = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'http://www.sharedeffects.com/api/auth',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'get',
});

var RESTService_Projects_list = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'https://www.sharedeffects.com/api/projects',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'get',
});

var Facebook_Token = new Apperyio.RestService({
    'url': 'https://api.appery.io/rest/1/proxy/tunnel',
    'proxyHeaders': {
        'appery-proxy-url': 'http://www.sharedeffects.com/api/facebookauth',
        'appery-transformation': 'checkTunnel',
        'appery-key': '1446696438287',
        'appery-rest': '57e9fdc0-0aba-4be5-89b6-80d78bbd33a2'
    },
    'dataType': 'json',
    'type': 'get',
});