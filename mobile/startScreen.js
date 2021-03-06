/*
 * JS for startScreen generated by Appery.io
 */

Apperyio.getProjectGUID = function() {
    return '4f47d7f5-362a-4b3c-8a2f-a4014ed03a5d';
};

function navigateTo(outcome, useAjax) {
    Apperyio.navigateTo(outcome, useAjax);
}

function adjustContentHeight() {
    Apperyio.adjustContentHeightWithPadding();
}

function adjustContentHeightWithPadding(_page) {
    Apperyio.adjustContentHeightWithPadding(_page);
}

function setDetailContent(pageUrl) {
    Apperyio.setDetailContent(pageUrl);
}

Apperyio.AppPages = [{
    "name": "EventAdd",
    "location": "EventAdd.html"
}, {
    "name": "EventView",
    "location": "EventView.html"
}, {
    "name": "ContactsSync",
    "location": "ContactsSync.html"
}, {
    "name": "Facebook_Me",
    "location": "Facebook_Me.html"
}, {
    "name": "Logout",
    "location": "Logout.html"
}, {
    "name": "MyProfile",
    "location": "MyProfile.html"
}, {
    "name": "startScreen",
    "location": "startScreen.html"
}, {
    "name": "Registration",
    "location": "Registration.html"
}, {
    "name": "Facebook_Return",
    "location": "Facebook_Return.html"
}, {
    "name": "AccountDetails",
    "location": "AccountDetails.html"
}];

function startScreen_js() {

    /* Object & array with components "name-to-id" mapping */
    var n2id_buf = {
        'navi_panel_button': 'startScreen_navi_panel_button',
        'btn_logout': 'startScreen_btn_logout',
        'mobilenavbar_34': 'startScreen_mobilenavbar_34',
        'top_menu_register': 'startScreen_top_menu_register',
        'top_menu_public_events': 'startScreen_top_menu_public_events',
        'btn_add_event_new': 'startScreen_btn_add_event_new',
        'email': 'startScreen_email',
        'password': 'startScreen_password',
        'sync_grid': 'startScreen_sync_grid',
        'mobilegridcell_155': 'startScreen_mobilegridcell_155',
        'mobilelabel_160': 'startScreen_mobilelabel_160',
        'mobilegridcell_156': 'startScreen_mobilegridcell_156',
        'tog_offline_sync_enable': 'startScreen_tog_offline_sync_enable',
        'button_login': 'startScreen_button_login',
        'rest_response': 'startScreen_rest_response',
        'login_message': 'startScreen_login_message',
        'btn_facebook_auth': 'startScreen_btn_facebook_auth',
        'btn_google_auth': 'startScreen_btn_google_auth',
        'btn_linkedin_auth': 'startScreen_btn_linkedin_auth',
        'mobilelabel_8': 'startScreen_mobilelabel_8',
        'keyword': 'startScreen_keyword',
        'start': 'startScreen_start',
        'search_button': 'startScreen_search_button',
        'EventGrid_123': 'startScreen_EventGrid_123',
        'mobilegridcell_99_124': 'startScreen_mobilegridcell_99_124',
        'event_name_125': 'startScreen_event_name_125',
        'mobilegridcell_101_126': 'startScreen_mobilegridcell_101_126',
        'mobilegrid_151': 'startScreen_mobilegrid_151',
        'mobilegridcell_152': 'startScreen_mobilegridcell_152',
        'event_image_127': 'startScreen_event_image_127',
        'mobilegridcell_153': 'startScreen_mobilegridcell_153',
        'event_catgeory_129': 'startScreen_event_catgeory_129',
        'start_date_131': 'startScreen_start_date_131',
        'end_date_133': 'startScreen_end_date_133',
        'mobilegridcell_103_128': 'startScreen_mobilegridcell_103_128',
        'event_latitude_135': 'startScreen_event_latitude_135',
        'mobilegridcell_104_130': 'startScreen_mobilegridcell_104_130',
        'event_longitude_137': 'startScreen_event_longitude_137',
        'mobilegridcell_105_132': 'startScreen_mobilegridcell_105_132',
        'event_id_139': 'startScreen_event_id_139',
        'mobilegridcell_106_134': 'startScreen_mobilegridcell_106_134',
        'image_141': 'startScreen_image_141',
        'navi_panel_list': 'startScreen_navi_panel_list',
        'navi_panel_list_details': 'startScreen_navi_panel_list_details',
        'mobilelistitembutton_83': 'startScreen_mobilelistitembutton_83',
        'navi_panel_list_personal': 'startScreen_navi_panel_list_personal',
        'mobilelistitembutton_85': 'startScreen_mobilelistitembutton_85',
        'btn_facebook': 'startScreen_btn_facebook',
        'mobilelistitembutton_115': 'startScreen_mobilelistitembutton_115',
        'btn_google': 'startScreen_btn_google',
        'mobilelistitembutton_117': 'startScreen_mobilelistitembutton_117',
        'btn_linkedin': 'startScreen_btn_linkedin',
        'mobilelistitembutton_119': 'startScreen_mobilelistitembutton_119',
        'navi_panel_list_myevents': 'startScreen_navi_panel_list_myevents',
        'mobilelistitembutton_87': 'startScreen_mobilelistitembutton_87',
        'navi_panel_list_wellbeing': 'startScreen_navi_panel_list_wellbeing',
        'mobilelistitembutton_89': 'startScreen_mobilelistitembutton_89',
        'navi_panel_list_social': 'startScreen_navi_panel_list_social',
        'mobilelistitembutton_91': 'startScreen_mobilelistitembutton_91',
        'mobilelistitem_96': 'startScreen_mobilelistitem_96',
        'mobilelistitembutton_97': 'startScreen_mobilelistitembutton_97',
        'navi_panel_list_contacts_sync': 'startScreen_navi_panel_list_contacts_sync',
        'mobilelistitembutton_95': 'startScreen_mobilelistitembutton_95'
    };

    if ("n2id" in window && window.n2id !== undefined) {
        $.extend(n2id, n2id_buf);
    } else {
        window.n2id = n2id_buf;
    }

    /*
     * Nonvisual components
     */

    Apperyio.mappings = Apperyio.mappings || {};

    Apperyio.mappings["startScreen_LoginRestService_onsuccess_mapping_1"] = {
        "homeScreen": "startScreen",
        "directions": [

        {
            "from_name": "LoginRestService",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "startScreen",
            "to_type": "UI",

            "mappings": [

            {

                "source": "$['body']['api_message']",
                "target": "$['login_message:text']"

            }

            ]
        },

        {
            "from_name": "LoginRestService",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "api_sess",
            "to_type": "SESSION_STORAGE",

            "mappings": [

            {

                "source": "$['body']['api_sess']",
                "target": "$"

            }

            ]
        },

        {
            "from_name": "LoginRestService",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "api_message",
            "to_type": "LOCAL_STORAGE",

            "mappings": [

            {

                "source": "$['body']['api_message']",
                "target": "$"

            }

            ]
        },

        {
            "from_name": "LoginRestService",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "api_response",
            "to_type": "LOCAL_STORAGE",

            "mappings": [

            {

                "source": "$['body']['api_response']",
                "target": "$"

            }

            ]
        }

        ]
    };

    Apperyio.mappings["startScreen_LoginRestService_onbeforesend_mapping_0"] = {
        "homeScreen": "startScreen",
        "directions": [

        {
            "from_name": "startScreen",
            "from_type": "UI",

            "to_name": "LoginRestService",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {
                    "application": "sharedeffects"
                },
                "parameters": {
                    "api_key": "de8891b2-4407-b4c4-f153-51cb64bac59e",
                    "action": "auth"
                },
                "body": null
            },

            "mappings": [

            {

                "source": "$['email:text']",
                "target_transformation": function(value) {
                    var email = Apperyio('email').val();
                    var password = Apperyio('password').val();
                    var calc = getAuth(email, password);
                    return calc;
                },
                "target": "$['parameters']['auth']"

            },

            {

                "source": "$['password:text']",
                "target_transformation": function(value) {
                    var email = Apperyio('email').val();
                    var password = Apperyio('password').val();
                    var calc = getAuth(email, password);
                    return calc;
                },
                "target": "$['parameters']['auth']"

            }

            ]
        }

        ]
    };

    Apperyio.mappings["startScreen_EventListingsService_onsuccess_mapping_0"] = {
        "homeScreen": "startScreen",
        "directions": [

        {
            "from_name": "EventListingsService",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "startScreen",
            "to_type": "UI",

            "mappings": [

            {

                "source": "$['body']['events'][i]",
                "target": "$['EventGrid_123']"

            },

            {

                "source": "$['body']['events'][i]['name']",
                "target": "$['EventGrid_123']['event_name_125:text']"

            },

            {

                "source": "$['body']['events'][i]['event_image_url']",
                "target": "$['EventGrid_123']['event_image_127:image']"

            },

            {

                "source": "$['body']['events'][i]['category_name']",
                "target": "$['EventGrid_123']['event_catgeory_129:text']"

            },

            {

                "source": "$['body']['events'][i]['start_date']",
                "target": "$['EventGrid_123']['start_date_131:text']"

            },

            {

                "source": "$['body']['events'][i]['end_date']",
                "target": "$['EventGrid_123']['end_date_133:text']"

            },

            {

                "source": "$['body']['events'][i]['latitude']",
                "target": "$['EventGrid_123']['event_latitude_135:text']"

            },

            {

                "source": "$['body']['events'][i]['longitude']",
                "target": "$['EventGrid_123']['event_longitude_137:text']"

            },

            {

                "source": "$['body']['events'][i]['event_id']",
                "target": "$['EventGrid_123']['event_id_139:text']"

            }

            ]
        }

        ]
    };

    Apperyio.mappings["startScreen_EventListingsService_onbeforesend_mapping_0"] = {
        "homeScreen": "startScreen",
        "directions": [

        {
            "from_name": "sess_acc",
            "from_type": "SESSION_STORAGE",

            "to_name": "EventListingsService",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {
                    "application": "sharedeffects"
                },
                "parameters": {
                    "action": "list",
                    "valtype": "ParEvents"
                },
                "body": null
            },

            "mappings": [

            {

                "source": "$",
                "target": "$['parameters']['sess_acc']"

            }

            ]
        },

        {
            "from_name": "sess_con",
            "from_type": "SESSION_STORAGE",

            "to_name": "EventListingsService",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {
                    "application": "sharedeffects"
                },
                "parameters": {
                    "action": "list",
                    "valtype": "ParEvents"
                },
                "body": null
            },

            "mappings": [

            {

                "source": "$",
                "target": "$['parameters']['sess_con']"

            }

            ]
        },

        {
            "from_name": "auth",
            "from_type": "LOCAL_STORAGE",

            "to_name": "EventListingsService",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {
                    "application": "sharedeffects"
                },
                "parameters": {
                    "action": "list",
                    "valtype": "ParEvents"
                },
                "body": null
            },

            "mappings": [

            {

                "source": "$",
                "target": "$['parameters']['auth']"

            }

            ]
        },

        {
            "from_name": "startScreen",
            "from_type": "UI",

            "to_name": "EventListingsService",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {
                    "application": "sharedeffects"
                },
                "parameters": {
                    "action": "list",
                    "valtype": "ParEvents"
                },
                "body": null
            },

            "mappings": [

            {

                "source": "$['keyword:text']",
                "target": "$['parameters']['keyword']"

            },

            {

                "source": "$['start:text']",
                "target": "$['parameters']['search_date']"

            }

            ]
        }

        ]
    };

    Apperyio.mappings["startScreen_FBAllowed_onsuccess_mapping_0"] = {
        "homeScreen": "startScreen",
        "directions": [

        {
            "from_name": "FBAllowed",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "allow_fb_rego",
            "to_type": "SESSION_STORAGE",

            "mappings": [

            {

                "source": "$['body']['allow_fb_rego']",
                "target": "$"

            }

            ]
        }

        ]
    };

    Apperyio.mappings["startScreen_FBAllowed_onbeforesend_mapping_0"] = {
        "homeScreen": "startScreen",
        "directions": [

        {

            "to_name": "FBAllowed",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {
                    "application": "sharedeffects"
                },
                "parameters": {
                    "action": "fb_allowed"
                },
                "body": null
            },

            "mappings": []
        }

        ]
    };

    Apperyio.datasources = Apperyio.datasources || {};

    window.LoginRestService = Apperyio.datasources.LoginRestService = new Apperyio.DataSource(RESTService_Auth, {
        "onBeforeSend": function(jqXHR) {
            Apperyio.processMappingAction(Apperyio.mappings["startScreen_LoginRestService_onbeforesend_mapping_0"]);
        },
        "onComplete": function(jqXHR, textStatus) {

        },
        "onSuccess": function(data) {
            toggle('startScreen_login_message', 'mob', 'true');
            Apperyio.processMappingAction(Apperyio.mappings["startScreen_LoginRestService_onsuccess_mapping_1"]);
            var sess_con = Apperyio.storage.sess_con.get();
            var sess_acc = Apperyio.storage.sess_acc.get();
            var response = Apperyio.storage.api_response.get();
            var fullresponse = JSON.stringify(data);

            Apperyio("rest_response").text(fullresponse);

            var response_sess_con = JSON.parse(fullresponse).sess_con;
            var response_sess_acc = JSON.parse(fullresponse).sess_acc;
            //var response_msg = JSON.parse(fullresponse).api_message;
            //alert(response_sess_con);
            //if (sess_con === "" && response_sess_con !== ""){
            if (response_sess_con) {
                sessionStorage.setItem('sess_con', response_sess_con);
                sessionStorage.setItem('sess_acc', response_sess_acc);
            }

/*
if (JSON.responseText == "[]") {
    Apperyio("rest_response").text("Nothing found");
    //Apperyio("rest_response").show(); 
}
*/

            if (response === "OK") {
                Apperyio.navigateTo("MyProfile");
            };
        },
        "onError": function(jqXHR, textStatus, errorThrown) {
            var msg = jqXHR.responseText;
            Apperyio('label_error_login').text('$' + msg);
        }
    });

    window.EventListingsService = Apperyio.datasources.EventListingsService = new Apperyio.DataSource(RESTService_Events_list, {
        "onBeforeSend": function(jqXHR) {
            Apperyio.processMappingAction(Apperyio.mappings["startScreen_EventListingsService_onbeforesend_mapping_0"]);
        },
        "onComplete": function(jqXHR, textStatus) {

        },
        "onSuccess": function(data) {
            Apperyio.processMappingAction(Apperyio.mappings["startScreen_EventListingsService_onsuccess_mapping_0"]);
            //var response = Apperyio.storage.api_response.get();
            //var event_image = Apperyio('event_image_127').val();
            //var event_image = Apperyio.getImagePath('event_image_127');
            var event_image = Apperyio('event_image_127');

            if (event_image) {
                Apperyio('event_image_127').show();
            } else {
                Apperyio('event_image_127').hide();
            };
        },
        "onError": function(jqXHR, textStatus, errorThrown) {}
    });

    window.FBAllowed = Apperyio.datasources.FBAllowed = new Apperyio.DataSource(Facebook_Allowed, {
        "onBeforeSend": function(jqXHR) {
            Apperyio.processMappingAction(Apperyio.mappings["startScreen_FBAllowed_onbeforesend_mapping_0"]);
        },
        "onComplete": function(jqXHR, textStatus) {

        },
        "onSuccess": function(data) {
            Apperyio.processMappingAction(Apperyio.mappings["startScreen_FBAllowed_onsuccess_mapping_0"]);
        },
        "onError": function(jqXHR, textStatus, errorThrown) {}
    });

    Apperyio.CurrentScreen = 'startScreen';
    _.chain(Apperyio.mappings).filter(function(m) {
        return m.homeScreen === Apperyio.CurrentScreen;
    }).each(Apperyio.UIHandler.hideTemplateComponents);

    /*
     * Events and handlers
     */

    // On Load
    var startScreen_onLoad = function() {
            startScreen_elementsExtraJS();

            var host = window.location.hostname;
            var isOpera = !! window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
            // Opera 8.0+ (UA detection to detect Blink/v8-powered Opera)
            var isFirefox = typeof InstallTrigger !== 'undefined'; // Firefox 1.0+
            var isSafari = Object.prototype.toString.call(window.HTMLElement).indexOf('Constructor') > 0;
            // At least Safari 3+: "[object HTMLElementConstructor]"
            var isChrome = !! window.chrome && !isOpera; // Chrome 1+
            var isIE = /*@cc_on!@*/
            false || !! document.documentMode; // At least IE6
            if (isChrome) {
                alert("Chrome" + host);
            }

            if (!isChrome && !isFirefox && !isOpera && !isIE) {
                alert("Dunno" + host);
            }

            var sess_con = Apperyio.storage.sess_con.get();
            var sess_acc = Apperyio.storage.sess_acc.get();
            var sess_facebook = Apperyio.storage.sess_facebook.get();
            //var allow_fb_rego = Apperyio.storage.allow_fb_rego.get();
            var sess_google = Apperyio.storage.sess_google.get();
            var sess_linkedin = Apperyio.storage.sess_linkedin.get();

            var configurations = Apperyio.storage.configurations.get();
            var offline_sync = Apperyio.storage.configurations.get("$['offline_sync_enable']");

/*
for (var i = 0; i < configurations.length; i++) {
    for (var offline_sync_enable in configurations[i]) {
        var offline_sync = configurations[i][offline_sync_enable];
        // log progress to the console
        //console.log(categoryid + " : " + category);
        //  ... do something
    }
}
*/

            //var configurations = JSON.parse(localStorage.getItem(configurations));
            //var offline_sync = configurations.offline_sync_enable;
            //var pushSettings = Apperyio.config('PushNotification');
            //var device_id = pushSettings.deviceId;
            //var device_token = pushSettings.token;
            //var device_id = PushNotification.getDeviceUniqueIdentifier();
            //Apperyio('login_message').text(device_id); 
            if (sess_con) {
                Apperyio('email').hide();
                Apperyio('password').hide();
                Apperyio('button_login').hide();
                Apperyio('btn_facebook_auth').hide();
                Apperyio('btn_google_auth').hide();
                Apperyio('btn_linkedin_auth').hide();
                Apperyio('btn_add_event_new').show();
                Apperyio('sync_grid').hide();
                //Apperyio('top_menu_register').hide();
                //Apperyio('top_menu_register').text('My Profile');
                Apperyio('top_menu_register').text('My Events');
                //Apperyio('top_menu_register').nav('MyProfile');
            } else {
                var email = localStorage.getItem('email');
                Apperyio('email').text(email);
                var password = localStorage.getItem('password');
                Apperyio('password').text(password);
                Apperyio('btn_logout').hide();
                Apperyio('navi_panel_button').hide();
                Apperyio('btn_add_event_new').hide();
                if (offline_sync === true) {
                    Apperyio('sync_grid').hide();
                }
                //if (allow_fb_rego === false){
                //   Apperyio('btn_facebook_auth').hide();            
                //   }
            };
            try {
                EventListingsService.execute({});
            } catch (e) {
                console.error(e);
                hideSpinner();
            };
            try {
                $a.storage["val"].update("$", "public_events")
            } catch (e) {
                console.error(e)
            };
            setAttribute_('startScreen_tog_offline_sync_enable', 'toggled', $a.storage["configurations"].get("$['offline_sync_enable']"));
            $('[id="startScreen_tog_offline_sync_enable"]').refresh();

            startScreen_deviceEvents();
            startScreen_windowEvents();
            startScreen_elementsEvents();
        };

    // screen window events


    function startScreen_windowEvents() {

        $('#startScreen').bind('pageshow orientationchange', function() {
            var _page = this;
            adjustContentHeightWithPadding(_page);
        });

    };

    // device events


    function startScreen_deviceEvents() {
        document.addEventListener("deviceready", function() {
            //onDeviceReady();
            $(document).off('online offline ').on({
                "online": function(event) { //onOnline();
                },
                "offline": function(event) { //onOffline();
                },
            });

        });
    };

    // screen elements extra js


    function startScreen_elementsExtraJS() {
        // screen (startScreen) extra code

        /* tog_offline_sync_enable */

        $("#startScreen_tog_offline_sync_enable").parent().find(".ui-flipswitch-on").attr("tabindex", "19");

        /* navi_panel_list */

        listView = $("#startScreen_navi_panel_list");
        theme = listView.attr("data-theme");
        if (typeof theme !== 'undefined') {
            var themeClass = "ui-btn-up-" + theme;
            listItem = $("#startScreen_navi_panel_list .ui-li-static");
            $.each(listItem, function(index, value) {
                $(this).addClass(themeClass);
            });
        }

        /* navi_panel_list_details */

        /* navi_panel_list_personal */

        /* btn_facebook */

        /* btn_google */

        /* btn_linkedin */

        /* navi_panel_list_myevents */

        /* navi_panel_list_wellbeing */

        /* navi_panel_list_social */

        /* mobilelistitem_96 */

        /* navi_panel_list_contacts_sync */

    };

    // screen elements handler


    function startScreen_elementsEvents() {
        $(document).on("click", "a :input,a a,a fieldset label", function(event) {
            event.stopPropagation();
        });

        $(document).off("click", '#startScreen_mobileheader [name="navi_panel_button"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    $('[id="startScreen_navi_panel"]').panel("open");

                }
            },
        }, '#startScreen_mobileheader [name="navi_panel_button"]');
        $(document).off("click", '#startScreen_mobileheader [name="btn_logout"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    setTimeout(function() {
                        window.location = 'Logout.html';
                    }, 0);

                }
            },
        }, '#startScreen_mobileheader [name="btn_logout"]');

        $(document).off("click", '#startScreen_mobileheader [name="top_menu_register"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    var sess_con = Apperyio.storage.sess_con.get();
                    if (sess_con) {
                        Appery.navigateTo('startScreen', {});
                        localStorage.setItem('action', 'my_events');
                    } else {
                        Appery.navigateTo('Registration', {});
                    };

                }
            },
        }, '#startScreen_mobileheader [name="top_menu_register"]');
        $(document).off("click", '#startScreen_mobileheader [name="top_menu_public_events"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    try {
                        $a.storage["action"].update("$", "public_events")
                    } catch (e) {
                        console.error(e)
                    };
                    setTimeout(function() {
                        window.location = 'startScreen.html';
                    }, 0);

                }
            },
        }, '#startScreen_mobileheader [name="top_menu_public_events"]');
        $(document).off("click", '#startScreen_mobileheader [name="btn_add_event_new"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    Apperyio.navigateTo('EventAdd', {
                        reverse: false
                    });

                }
            },
        }, '#startScreen_mobileheader [name="btn_add_event_new"]');

        $(document).off("change", '#startScreen_mobilecontainer [name="tog_offline_sync_enable"]').on({
            change: function(event) {
                try {
                    $a.storage["configurations"].update("$['offline_sync_enable']", $a.c15r($a.UIHandler.resolveGeneratedComponent('tog_offline_sync_enable', this), 'get', 'toggled'))
                } catch (e) {
                    console.error(e)
                };
            },
        }, '#startScreen_mobilecontainer [name="tog_offline_sync_enable"]');
        $(document).off("click", '#startScreen_mobilecontainer [name="button_login"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    var email = Apperyio('email').val();
                    localStorage.setItem('email', email);
                    var password = Apperyio('password').val();
                    localStorage.setItem('password', password);
                    var tog_offline_sync_enable = Apperyio('tog_offline_sync_enable').val();
                    localStorage.setItem('tog_offline_sync_enable', tog_offline_sync_enable);
                    //alert("Toggle is " + tog_offline_sync_enable);
                    try {
                        LoginRestService.execute({});
                    } catch (e) {
                        console.error(e);
                        hideSpinner();
                    };

                }
            },
        }, '#startScreen_mobilecontainer [name="button_login"]');

        $(document).off("click", '#startScreen_mobilecontainer [name="btn_facebook_auth"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    FBHelper.init();

                }
            },
        }, '#startScreen_mobilecontainer [name="btn_facebook_auth"]');
        $(document).off("click", '#startScreen_mobilecontainer [name="btn_google_auth"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    GoogleHelper.init();

                }
            },
        }, '#startScreen_mobilecontainer [name="btn_google_auth"]');
        $(document).off("click", '#startScreen_mobilecontainer [name="btn_linkedin_auth"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    LinkedInHelper.init();

                }
            },
        }, '#startScreen_mobilecontainer [name="btn_linkedin_auth"]');

        $(document).off("click", '#startScreen_mobilecontainer [name="search_button"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    try {
                        EventListingsService.execute({});
                    } catch (e) {
                        console.error(e);
                        hideSpinner();
                    };

                }
            },
        }, '#startScreen_mobilecontainer [name="search_button"]');

        $(document).off("click", '#startScreen_mobilecontainer [name="event_name_125"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    try {
                        $a.storage["val"].update("$", $a.c15r($a.UIHandler.resolveGeneratedComponent('event_id_139', this), 'get', 'text'))
                    } catch (e) {
                        console.error(e)
                    };
                    try {
                        $a.storage["valtype"].update("$", "Events")
                    } catch (e) {
                        console.error(e)
                    };
                    setTimeout(function() {
                        window.location = 'EventView.html';
                    }, 0);

                }
            },
        }, '#startScreen_mobilecontainer [name="event_name_125"]');

        $('#startScreen_navi_panel').off("panelopen").on("panelopen", function(event) {
            var sess_con = Apperyio.storage.sess_con.get();
            var sess_acc = Apperyio.storage.sess_acc.get();
            var sess_facebook = Apperyio.storage.sess_facebook.get();
            var sess_google = Apperyio.storage.sess_google.get();
            var sess_linkedin = Apperyio.storage.sess_linkedin.get();

            if (sess_facebook) {
                Apperyio('btn_facebook').hide();
            }

            if (sess_google) {
                Apperyio('btn_google').hide();
            }

            if (sess_linkedin) {
                Apperyio('btn_linkedin').hide();
            }

            //    Apperyio('btn_add_event_new').show();
            ;
        });

        $(document).off("click", '#startScreen_navi_panel [name="navi_panel_list_personal"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    Apperyio.navigateTo('MyProfile', {
                        reverse: false
                    });

                }
            },
        }, '#startScreen_navi_panel [name="navi_panel_list_personal"]');

        $(document).off("click", '#startScreen_navi_panel [name="btn_facebook"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    FBHelper.init();

                }
            },
        }, '#startScreen_navi_panel [name="btn_facebook"]');

        $(document).off("click", '#startScreen_navi_panel [name="navi_panel_list_myevents"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    setTimeout(function() {
                        window.location = 'startScreen.html';
                    }, 0);
                    try {
                        $a.storage["action"].update("$", "my_events")
                    } catch (e) {
                        console.error(e)
                    };

                }
            },
        }, '#startScreen_navi_panel [name="navi_panel_list_myevents"]');

        $(document).off("click", '#startScreen_navi_panel [name="navi_panel_list_contacts_sync"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    Apperyio.navigateTo('ContactsSync', {
                        reverse: false
                    });

                }
            },
        }, '#startScreen_navi_panel [name="navi_panel_list_contacts_sync"]');

    };

    $(document).off("pagebeforeshow", "#startScreen").on("pagebeforeshow", "#startScreen", function(event, ui) {
        Apperyio.CurrentScreen = "startScreen";
        _.chain(Apperyio.mappings).filter(function(m) {
            return m.homeScreen === Apperyio.CurrentScreen;
        }).each(Apperyio.UIHandler.hideTemplateComponents);
    });

    startScreen_onLoad();
};

$(document).off("pagecreate", "#startScreen").on("pagecreate", "#startScreen", function(event, ui) {
    Apperyio.processSelectMenu($(this));
    startScreen_js();
});