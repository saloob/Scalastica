// The root URL for the RESTful services
var rootURL = "http://www.scalastica.com/api/";

function error_msg (jqXHR) {
        var msg = '';
        if (jqXHR.status === 0) {
            msg = 'Not connect.\n Verify Network.';
        } else if (jqXHR.status == 404) {
            msg = 'Requested page not found. [404]';
        } else if (jqXHR.status == 500) {
            msg = 'Internal Server Error [500].';
        } else if (exception === 'parsererror') {
            msg = 'Requested JSON parse failed.';
        } else if (exception === 'timeout') {
            msg = 'Time out error.';
        } else if (exception === 'abort') {
            msg = 'Ajax request aborted.';
        } else {
            msg = 'Uncaught Error.\n' + jqXHR.responseText;
        }
        //$('#post').html(msg);
        alert (msg);
    }

function GetModules() {
	console.log('GetModules');
	$.ajax({
		type: 'GET',
		url: rootURL + 'modules/',
		dataType: "json",
		success: renderModuleList,
                error: error_msg
	});
}

function renderModuleList(data) {
        var modules = data.modules;
	$('#ModuleList li').remove();
	$.each(modules, function(index, module) {
		$('#ModuleList').append('<li id="module_li_' + module.id + '" class="ui-sortable-handle"><a href="javascript:void(0);" style="float:none;" class="module_link" data-identity="' + module.id + '" alt="">'+module.name+'</a></li>');

	});
}
