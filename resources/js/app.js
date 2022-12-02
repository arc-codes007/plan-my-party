require('./bootstrap');


window.$ = require('jquery');
import 'datatables.net-dt'

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ajaxError(function( event, response) {
    if(response.status == 402)
    {
        if(Object.keys(response.responseJSON).includes('redirect'))
        {
            window.location.href = response.responseJSON.redirect;
        }
    }
});

require('select2');

$(document).ready(function(){
    $('select').select2({
        width: $(this).data('width'),
    });

    $(".select2-tags").select2({
        tags: true
      });    
});
