/*
 * JS for Facebook_Return generated by Appery.io
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

function Facebook_Return_js() {

    /* Object & array with components "name-to-id" mapping */
    var n2id_buf = {
        'btn_home': 'Facebook_Return_btn_home',
        'fb_token': 'Facebook_Return_fb_token',
        'sess_acc': 'Facebook_Return_sess_acc',
        'sess_con': 'Facebook_Return_sess_con',
        'api_message': 'Facebook_Return_api_message',
        'rest_response': 'Facebook_Return_rest_response',
        'fb_sess': 'Facebook_Return_fb_sess'
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

    Apperyio.mappings["Facebook_Return_FBTokeniser_onsuccess_mapping_0"] = {
        "homeScreen": "Facebook_Return",
        "directions": [

        {
            "from_name": "FBTokeniser",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "Facebook_Return",
            "to_type": "UI",

            "mappings": [

            {

                "source": "$['body']['fb_token']",
                "target": "$['fb_token:text']"

            },

            {

                "source": "$['body']['sess_con']",
                "target": "$['sess_con:text']"

            },

            {

                "source": "$['body']['sess_acc']",
                "target": "$['sess_acc:text']"

            },

            {

                "source": "$['body']['api_message']",
                "target": "$['api_message:text']"

            }

            ]
        },

        {
            "from_name": "FBTokeniser",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "api_response",
            "to_type": "LOCAL_STORAGE",

            "mappings": [

            {

                "source": "$['body']['api_response']",
                "target": "$"

            }

            ]
        },

        {
            "from_name": "FBTokeniser",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "sess_facebook",
            "to_type": "SESSION_STORAGE",

            "mappings": [

            {

                "source": "$['body']['fb_token']",
                "target": "$"

            }

            ]
        },

        {
            "from_name": "FBTokeniser",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "sess_con",
            "to_type": "SESSION_STORAGE",

            "mappings": [

            {

                "source": "$['body']['sess_con']",
                "target": "$"

            }

            ]
        },

        {
            "from_name": "FBTokeniser",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "sess_acc",
            "to_type": "SESSION_STORAGE",

            "mappings": [

            {

                "source": "$['body']['sess_acc']",
                "target": "$"

            }

            ]
        }

        ]
    };

    Apperyio.mappings["Facebook_Return_FBTokeniser_onbeforesend_mapping_0"] = {
        "homeScreen": "Facebook_Return",
        "directions": [

        {
            "from_name": "fb_access_token",
            "from_type": "LOCAL_STORAGE",

            "to_name": "FBTokeniser",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {},
                "parameters": {},
                "body": null
            },

            "mappings": [

            {

                "source": "$",
                "target": "$['parameters']['fb_access_token']"

            }

            ]
        }

        ]
    };

    Apperyio.datasources = Apperyio.datasources || {};

    window.FBTokeniser = Apperyio.datasources.FBTokeniser = new Apperyio.DataSource(Facebook_Token, {
        "onBeforeSend": function(jqXHR) {
            Apperyio.processMappingAction(Apperyio.mappings["Facebook_Return_FBTokeniser_onbeforesend_mapping_0"]);
        },
        "onComplete": function(jqXHR, textStatus) {
            //var sess_con = localStorage.getItem("sess_con");
            var sess_con = Apperyio.storage.sess_con.get();
            var ref;

            if (sess_con) {
                Apperyio.storage.sess_con.set(sess_con);
                localStorage.setItem('sess_con', sess_con);
                ref = window.location.href;
                ref.close();
                Apperyio.navigateTo("MyProfile", {});
            };

        },
        "onSuccess": function(data) {
            Apperyio.processMappingAction(Apperyio.mappings["Facebook_Return_FBTokeniser_onsuccess_mapping_0"]);
            //var response = jqXHR.responseText;
            //Apperyio("rest_response").text(response);
/*
if (jqXHR.responseText == "[]") {
    //Apperyio("no_records").text("Nothing found");
    //Apperyio("no_records").show();
    Apperyio("rest_response").text(response);
    }
*/
            ;
        },
        "onError": function(jqXHR, textStatus, errorThrown) {}
    });

    Apperyio.CurrentScreen = 'Facebook_Return';
    _.chain(Apperyio.mappings).filter(function(m) {
        return m.homeScreen === Apperyio.CurrentScreen;
    }).each(Apperyio.UIHandler.hideTemplateComponents);

    /*
     * Events and handlers
     */

    // On Load
    var Facebook_Return_onLoad = function() {
            Facebook_Return_elementsExtraJS();

/*
function getUrlObj() {
  var parameters = location.search.substring(1).split("&");
  var obj = {};
  for( var i = 0; i < parameters.length; ++i) {
    var tmp = parameters[i].split("=");
    obj[ tmp[0] ] = unescape( tmp[1] );
  }
  return obj;
}


function $_GET(param) {
	var vars = {};
	window.location.href.replace( 
		/[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
		function( m, key, value ) { // callback
			vars[key] = value !== undefined ? value : '';
		}
	);

	if ( param ) {
		return vars[param] ? vars[param] : null;	
	}
	return vars;
}
*/
            //var $_GET = $_GET();
            //var fb_access_token = $_GET.fb_access_token;
            //var fb_access_token = $_GET('fb_access_token');
            //var _fb_access_token = getUrlObj.fb_access_token;

            function getQueryVariable(variable) {
                var query = window.location.search.substring(1);
                var vars = query.split("&");
                for (var i = 0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if (pair[0] == variable) {
                        return pair[1];
                    }
                }
                return (false);
            }

            //var accessToken = localStorage.getItem("fb_access_token");
            var _fb_access_token = getQueryVariable("fb_access_token");
            Apperyio.storage.fb_access_token.set(_fb_access_token);
            localStorage.setItem('fb_access_token', _fb_access_token);
            try {
                FBTokeniser.execute({});
            } catch (e) {
                console.error(e);
                hideSpinner();
            };

            Facebook_Return_deviceEvents();
            Facebook_Return_windowEvents();
            Facebook_Return_elementsEvents();
        };

    // screen window events


    function Facebook_Return_windowEvents() {

        $('#Facebook_Return').bind('pageshow orientationchange', function() {
            var _page = this;
            adjustContentHeightWithPadding(_page);
        });

    };

    // device events


    function Facebook_Return_deviceEvents() {
        document.addEventListener("deviceready", function() {

        });
    };

    // screen elements extra js


    function Facebook_Return_elementsExtraJS() {
        // screen (Facebook_Return) extra code

    };

    // screen elements handler


    function Facebook_Return_elementsEvents() {
        $(document).on("click", "a :input,a a,a fieldset label", function(event) {
            event.stopPropagation();
        });

        $(document).off("click", '#Facebook_Return_mobileheader [name="btn_home"]').on({
            click: function(event) {
                if (!$(this).attr('disabled')) {
                    setTimeout(function() {
                        window.location = 'startScreen.html';
                    }, 0);

                }
            },
        }, '#Facebook_Return_mobileheader [name="btn_home"]');

    };

    $(document).off("pagebeforeshow", "#Facebook_Return").on("pagebeforeshow", "#Facebook_Return", function(event, ui) {
        Apperyio.CurrentScreen = "Facebook_Return";
        _.chain(Apperyio.mappings).filter(function(m) {
            return m.homeScreen === Apperyio.CurrentScreen;
        }).each(Apperyio.UIHandler.hideTemplateComponents);
    });

    Facebook_Return_onLoad();
};

$(document).off("pagecreate", "#Facebook_Return").on("pagecreate", "#Facebook_Return", function(event, ui) {
    Apperyio.processSelectMenu($(this));
    Facebook_Return_js();
});