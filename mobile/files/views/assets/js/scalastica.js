function getHash(password) {
       var hash = CryptoJS.MD5(password);
       return hash;
    }

function getAuth(email,password) {
   var pass = getHash(password);
   var auth = "{"+email+":"+pass+"}";
   return auth;
 }

function createRandom(){
    var now = new Date().getTime();
    var random = getHash(now);
    return random;
    }

function isHTML(str) {
    var a = document.createElement('div');
    a.innerHTML = str;
    for (var c = a.childNodes, i = c.length; i--; ) {
        if (c[i].nodeType == 1) return true; 
    }
    return false;
}

// https://devcenter.appery.io/tutorials/building-a-simple-todo-app-with-appery-io-backend-services-part-2-working-in-offline-mode/

// Constructor ofevent
function EventToSynchronize(name, id) {
    this.id = id;
    this.name = name;
}
 
// Array of events to be deleted when online
var eventsToDelete = [];
// Array of events to be created when online
var eventsToCreate = [];

// If there is no network connection
function addEventToDelete(id, name) {
    var tmpEvent = new EventToSynchronize(name, id);
    eventsToDelete.push(JSON.stringify(tmpEvent));
    localStorage.setItem('_eventsToDelete', eventsToDelete);
}
 
function addEventToCreate(name) {
    var tmpEvent = new EventToSynchronize(name);
    eventsToCreate.push(JSON.stringify(tmpEvent));
    localStorage.setItem('_eventsToCreate', eventsToCreate);
}
 
function removeEventFromCreateList(name, list) {
    $(list).each(function(index, Element) {
        if (Element.name === name) {
            list.splice(index, 1);
        }
    });
    return list;
}
 
// Start synchronization of events with cloud
function startSynchronization() {
    var isOnline = localStorage.getItem('_isOnline');
    if (isOnline == 1) {
        var event;
 
        // Deleting
        var events = localStorage.getItem('_eventsToDelete');
        if (events) {
            var eventsArr = eval('([' + events + '])');
            while (eventsArr.length) {
                event = eventsArr.shift();
                if (event.id) {
                    delete_service.execute({
                        data: {
                            object_id: event.id
                        }
                    });
                }
            }
            localStorage.setItem('_eventsToDelete', '');
        }
 
        // Creating
        events = localStorage.getItem('_eventsToCreate');
        if (events) {
            var eventsArr = eval('([' + events + '])');
            while (eventsArr.length) {
                event = eventsArr.shift();
                if (event.name) {
                    create_service.execute({
                        data: {
                            event: event.name
                        }
                    });
                }
            }
            localStorage.setItem('_eventsToCreate', '');
        }
    }
    listServiceExecute();
}
 
// Delete event from list
function removeEventFromLocalList(id, echo, name) {
    if (id) {
        $(echo).each(function(index, Element) {
            if (Element._id === id) {
                echo.splice(index, 1);
            }
        });
    } else if (name) {
        $(echo).each(function(index, Element) {
            if (Element.event === name) {
                echo.splice(index, 1);
            }
        });
    }
    return echo;
}
 
// Add event to the local list
function addEventToLocalList(name, echo) {
    var tmpEvent = {};
    tmpEvent._id = '';
 
    tmpEvent.event = name;
    echo.push(tmpEvent);
    return echo;
}
 
// Check connection
function checkConnection() {
    if (navigator && navigator.network && navigator.network.connection && navigator.network.connection.type) {
        var networkState = navigator.network.connection.type;
 
        if (networkState !== Connection.NONE) {
            onOnline();
        } else {
            onOffline();
        }
        // When debug only (in desktop browser)
    } else {
        onOnline();
        $('[dsid="footer"]').text('Browser mode');
    }
}
 
// On device ready
function onDeviceReady() {
    checkConnection();
    listServiceExecute();
}
 
// On offline
function onOffline() {
    localStorage.setItem('_isOnline', 0);
    $('[dsid="footer"]').text('Offline');
}
 
// On online
function onOnline() {
    localStorage.setItem('_isOnline', 1);
    $('[dsid="footer"]').text('Online');
    startSynchronization();
}
 
// List service execute
function listServiceExecute() {
    var isOnline = localStorage.getItem('_isOnline');
    if (isOnline == 1) {
        list_service.service.__requestOptions.echo = '';
        list_service.execute({});
    } else {
        list_service.service.__requestOptions.echo = localStorage.getItem('_echo') ? localStorage.getItem('_echo') : '';
        list_service.execute();
    }
}
 
// Delete service execute
function deleteServiceExecute() {
    var isOnline = localStorage.getItem('_isOnline');
    if (isOnline == 1) {
        delete_service.execute({});
    } else {
        var idToDelete = localStorage.getItem('_eventId');
        var nameToDelete = localStorage.getItem('_eventName');
        if (idToDelete) {
            addEventToDelete(idToDelete, nameToDelete);
        } else {
            var events = localStorage.getItem('_eventsToCreate');
            var eventsObj = eval('([' + events + '])');
            removeEventFromCreateList(nameToDelete, eventsObj);
            events = JSON.stringify(eventsObj);
            localStorage.setItem('_eventsToCreate', events);
        }
 
        var tmpEcho = localStorage.getItem('_echo');
        tmpEcho = eval('(' + tmpEcho + ')');
        tmpEcho = removeEventFromLocalList(idToDelete, tmpEcho, nameToDelete);
        tmpEcho = JSON.stringify(tmpEcho);
        localStorage.setItem('_echo', tmpEcho);
 
        listServiceExecute();
    }
}
 
// Create service execute
function createServiceExecute() {
    var isOnline = localStorage.getItem('_isOnline');
    var nameToCreate = localStorage.getItem('_eventName');
    if (nameToCreate && nameToCreate.trim()) {
        if (isOnline == 1) {
            create_service.execute({});
        } else {
 
            addEventToCreate(nameToCreate);
            var tmpEcho = localStorage.getItem('_echo');
            tmpEcho = eval('(' + tmpEcho + ')') || [];
            tmpEcho = addEventToLocalList(nameToCreate, tmpEcho);
            tmpEcho = JSON.stringify(tmpEcho);
            localStorage.setItem('_echo', tmpEcho);
 
            listServiceExecute();
        }
    }
}