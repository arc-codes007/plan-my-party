require('./bootstrap');


var $ = require( "jquery" );

require('select2');
$('select').select2();

$(".select2-tags").select2({
    tags: true
  });
