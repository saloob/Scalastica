/*
 * JS for Facebook_Me generated by Appery.io
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

function Facebook_Me_js() {

    /* Object & array with components "name-to-id" mapping */
    var n2id_buf = {
        'Name': 'Facebook_Me_Name',
        'Link': 'Facebook_Me_Link',
        'Education': 'Facebook_Me_Education',
        'mobilegridcell1': 'Facebook_Me_mobilegridcell1',
        'SchoolName': 'Facebook_Me_SchoolName',
        'Work': 'Facebook_Me_Work',
        'mobilegridcell3': 'Facebook_Me_mobilegridcell3',
        'Employer': 'Facebook_Me_Employer'
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

    Apperyio.mappings["Facebook_Me_meService_onbeforesend_mapping_0"] = {
        "homeScreen": "Facebook_Me",
        "directions": [

        {
            "from_name": "access_token",
            "from_type": "LOCAL_STORAGE",

            "to_name": "meService",
            "to_type": "SERVICE_REQUEST",

            "to_default": {
                "headers": {},
                "parameters": {
                    "access_token": "{access_token}"
                },
                "body": null
            },

            "mappings": [

            {

                "source": "$",
                "target": "$['parameters']['access_token']"

            }

            ]
        }

        ]
    };

    Apperyio.mappings["Facebook_Me_meService_onsuccess_mapping_0"] = {
        "homeScreen": "Facebook_Me",
        "directions": [

        {
            "from_name": "meService",
            "from_type": "SERVICE_RESPONSE",

            "to_name": "Facebook_Me",
            "to_type": "UI",

            "mappings": [

            {

                "source": "$['body']['link']",
                "target": "$['Link:text']"

            },

            {

                "source": "$['body']['name']",
                "target": "$['Name:text']"

            },

            {

                "source": "$['body']['education'][i]",
                "target": "$['Education']"

            },

            {

                "source": "$['body']['work'][i]['employer']['name']",
                "target": "$['Work']['Employer:text']"

            },

            {

                "source": "$['body']['education'][i]['school']['name']",
                "target": "$['Education']['SchoolName:text']"

            },

            {

                "source": "$['body']['work'][i]",
                "target": "$['Work']"

            }

            ]
        }

        ]
    };

    Apperyio.datasources = Apperyio.datasources || {};

    window.meService = Apperyio.datasources.meService = new Apperyio.DataSource(Facebook_MeService, {
        "onBeforeSend": function(jqXHR) {
            Apperyio.processMappingAction(Apperyio.mappings["Facebook_Me_meService_onbeforesend_mapping_0"]);
        },
        "onComplete": function(jqXHR, textStatus) {

        },
        "onSuccess": function(data) {
            Apperyio.processMappingAction(Apperyio.mappings["Facebook_Me_meService_onsuccess_mapping_0"]);
        },
        "onError": function(jqXHR, textStatus, errorThrown) {}
    });

    Apperyio.CurrentScreen = 'Facebook_Me';
    _.chain(Apperyio.mappings).filter(function(m) {
        return m.homeScreen === Apperyio.CurrentScreen;
    }).each(Apperyio.UIHandler.hideTemplateComponents);

    /*
     * Events and handlers
     */

    // On Load
    var Facebook_Me_onLoad = function() {
            Facebook_Me_elementsExtraJS();

            try {
                meService.execute({});
            } catch (e) {
                console.error(e);
                hideSpinner();
            };

            Facebook_Me_deviceEvents();
            Facebook_Me_windowEvents();
            Facebook_Me_elementsEvents();
        };

    // screen window events


    function Facebook_Me_windowEvents() {

        $('#Facebook_Me').bind('pageshow orientationchange', function() {
            var _page = this;
            adjustContentHeightWithPadding(_page);
        });

    };

    // device events


    function Facebook_Me_deviceEvents() {
        document.addEventListener("deviceready", function() {

        });
    };

    // screen elements extra js


    function Facebook_Me_elementsExtraJS() {
        // screen (Facebook_Me) extra code

    };

    // screen elements handler


    function Facebook_Me_elementsEvents() {
        $(document).on("click", "a :input,a a,a fieldset label", function(event) {
            event.stopPropagation();
        });

    };

    $(document).off("pagebeforeshow", "#Facebook_Me").on("pagebeforeshow", "#Facebook_Me", function(event, ui) {
        Apperyio.CurrentScreen = "Facebook_Me";
        _.chain(Apperyio.mappings).filter(function(m) {
            return m.homeScreen === Apperyio.CurrentScreen;
        }).each(Apperyio.UIHandler.hideTemplateComponents);
    });

    Facebook_Me_onLoad();
};

$(document).off("pagecreate", "#Facebook_Me").on("pagecreate", "#Facebook_Me", function(event, ui) {
    Apperyio.processSelectMenu($(this));
    Facebook_Me_js();
});