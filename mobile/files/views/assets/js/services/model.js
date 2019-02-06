/**
 * Data models
 */
Apperyio.Entity = new Apperyio.EntityFactory({
    "TempArray": {
        "type": "array",
        "items": {
            "type": "string"
        }
    },
    "Locations": {
        "type": "object",
        "properties": {
            "location_latitude": {
                "type": "string"
            },
            "location_name": {
                "type": "string"
            },
            "location_id": {
                "type": "string"
            },
            "location_address": {
                "type": "string"
            },
            "location_country": {
                "type": "string"
            },
            "location_city": {
                "type": "string"
            },
            "location_longitude": {
                "type": "string"
            }
        }
    },
    "Number": {
        "type": "number"
    },
    "configurations": {
        "type": "object",
        "properties": {
            "auto_logging_distance": {
                "type": "number"
            },
            "auto_logging_enabled": {
                "type": "boolean"
            },
            "offline_sync_enable": {
                "type": "boolean"
            },
            "auto_logging_interval": {
                "type": "number"
            }
        }
    },
    "Boolean": {
        "type": "boolean"
    },
    "String": {
        "type": "string"
    },
    "Events": {
        "type": "object",
        "properties": {
            "event_longitude": {
                "type": "string"
            },
            "event_id": {
                "type": "string"
            },
            "event_name": {
                "type": "string"
            },
            "location_id": {
                "type": "string"
            },
            "event_latitude": {
                "type": "string"
            }
        }
    }
});
Apperyio.getModel = Apperyio.Entity.get.bind(Apperyio.Entity);

/**
 * Data storage
 */
Apperyio.storage = {

    "api_sess": new $a.SessionStorage("api_sess", "String"),

    "auth": new $a.LocalStorage("auth", "String"),

    "api_response": new $a.LocalStorage("api_response", "String"),

    "api_message": new $a.LocalStorage("api_message", "String"),

    "fb_access_token": new $a.SessionStorage("fb_access_token", "String"),

    "allow_fb_rego": new $a.SessionStorage("allow_fb_rego", "Boolean"),

    "valtype": new $a.LocalStorage("valtype", "String"),

    "val": new $a.LocalStorage("val", "String"),

    "sess_con": new $a.SessionStorage("sess_con", "String"),

    "sess_acc": new $a.SessionStorage("sess_acc", "String"),

    "locations": new $a.LocalStorage("locations", "Locations"),

    "action": new $a.LocalStorage("action", "String"),

    "sess_facebook": new $a.SessionStorage("sess_facebook", "String"),

    "sess_linkedin": new $a.SessionStorage("sess_linkedin", "String"),

    "sess_google": new $a.SessionStorage("sess_google", "String"),

    "project_id": new $a.LocalStorage("project_id", "String"),

    "temp_id": new $a.LocalStorage("temp_id", "String"),

    "configurations": new $a.LocalStorage("configurations", "configurations"),

    "temparray": new $a.LocalStorage("temparray", "TempArray"),

    "access_token": new $a.LocalStorage("access_token", "String")
};