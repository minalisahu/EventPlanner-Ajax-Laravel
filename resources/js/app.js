/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');
 require('jquery-ui/ui/widgets/datepicker.js');
 require('jquery-validation/dist/jquery.validate.js');
 require('jquery-confirm/js/jquery-confirm');
 import 'select2';  // globally assign select2 fn to $ element


 window.Vue = require('vue').default;
 

 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */
 Vue.component('drop-down', require('./components/input/DropDown.vue').default);

 const app = new Vue({
     el: '#app',
 });
 
 
 (function ($) {
     "use strict"; // Start of use strict
     $('.simple-select').select2();

     $(".multiple-select").select2({
         placeholder: "Select here"
     });
     
     $('.datepicker').datepicker();

     $('.datepicker-with-month-year').datepicker({
         changeMonth: true,
         changeYear: true,
         maxDate: -730,
         yearRange: "2005:now"
     });
 
 
 })(jQuery);
 

 
 window.show = function (token, route, cl = '') {
     $.ajax(route, {
         type: "GET",
         data: ({ _token: token }),
         success: function (response) {
             $('#showModalClass').addClass(cl);
             $("#showModelBody").html(response);
             $("#showModel").modal('show');
         }
     });
 }
 
 
 window.trash = function (id) {
     $.confirm({
         title: 'Confirm!',
         content: 'Are you sure, you want to remove this event?',
         buttons: {
             yes: function () {
                 $('#delete_form_' + id).submit();
             },
             no: function () {
 
             }
         }
     });
 }
 
