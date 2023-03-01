const bootstrap = require('bootstrap')
window.bootstrap = bootstrap;
window.$ = require('jquery');
import 'datatables.net-dt'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.alertify = require('alertifyjs');

require('select2');

$(document).ready(function(){
    $('select').select2({
        width: $(this).data('width'),
    });

    $(".select2-tags").select2({
        tags: true
      });    

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});


alertify.defaults = {
    // dialogs defaults
    autoReset:true,
    basic:false,
    closable:true,
    closableByDimmer:true,
    invokeOnCloseOff:false,
    frameless:false,
    defaultFocusOff:false,
    maintainFocus:true, // <== global default not per instance, applies to all dialogs
    maximizable:true,
    modal:true,
    movable:true,
    moveBounded:false,
    overflow:true,
    padding: true,
    pinnable:true,
    pinned:true,
    preventBodyShift:false, // <== global default not per instance, applies to all dialogs
    resizable:true,
    startMaximized:false,
    transition:'pulse',
    transitionOff:false,
    tabbable:'button:not(:disabled):not(.ajs-reset),[href]:not(:disabled):not(.ajs-reset),input:not(:disabled):not(.ajs-reset),select:not(:disabled):not(.ajs-reset),textarea:not(:disabled):not(.ajs-reset),[tabindex]:not([tabindex^="-"]):not(:disabled):not(.ajs-reset)',  // <== global default not per instance, applies to all dialogs

    // notifier defaults
    notifier:{
    // auto-dismiss wait time (in seconds)  
        delay:5,
    // default position
        position:'bottom-right',
    // adds a close button to notifier messages
        closeButton: false,
    // provides the ability to rename notifier classes
        classes : {
            base: 'alertify-notifier',
            prefix:'ajs-',
            message: 'ajs-message',
            top: 'ajs-top',
            right: 'ajs-right',
            bottom: 'ajs-bottom',
            left: 'ajs-left',
            center: 'ajs-center',
            visible: 'ajs-visible',
            hidden: 'ajs-hidden',
            close: 'ajs-close'
        }
    },

    // language resources 
    glossary:{
        // dialogs default title
        title:'AlertifyJS',
        // ok button text
        ok: 'OK',
        // cancel button text
        cancel: 'Cancel'            
    },

    // theme settings
    theme:{
        // class name attached to prompt dialog input textbox.
        input:'ajs-input form-control',
        // class name attached to ok button
        ok:'ajs-ok btn btn-primary text-white',
        // class name attached to cancel button 
        cancel:'ajs-cancel  btn btn-outline-primary'
    },
    // global hooks
    hooks:{
        // invoked before initializing any dialog
        preinit:function(instance){},
        // invoked after initializing any dialog
        postinit:function(instance){},
    },
};

$(document).ajaxError(function( event, response) {
    if(response.status == 402)
    {
        if(Object.keys(response.responseJSON).includes('redirect'))
        {
            window.location.href = response.responseJSON.redirect;
        }
    }
    else
    {  
        let errors = response.responseJSON.errors;
        let error_str = "<ul>";
        for(let field_name in errors)
        {
            error_str += "<li>"+errors[field_name]+"</li>"
        }
        error_str += "</ul>";
        alertify.alert('Error', error_str);
    }
});

import './common_functions';