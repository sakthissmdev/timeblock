(function($, Drupal, drupalSettings){
    'use strict';
    var timezone ="";

    Drupal.behaviors.specbeeTime = {
        attach: function(context) {
            timezone = drupalSettings.timezone
        }
    }

    $(document).ready(function(){
        //updating time
        window.setInterval(function(){
            //formatting the time in required (11:05 PM) format
            var formatter=new Intl.DateTimeFormat([],{
                timeZone: timezone,
                hour: 'numeric',
                minute: 'numeric',
            });
            var time = formatter.format(new Date()); 
            //updating date
            var date = new Intl.DateTimeFormat('en-GB', { dateStyle: 'full', }).format(new Date());  
            //rendering the updated date and time using selector.
            $(".time-details").html(time);
            $(".date-details").html(date);
        },1000);

    });

})(jQuery, Drupal, drupalSettings);
