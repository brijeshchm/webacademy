
// Not working? Did you `npm install` `npm run build` first?

var $ = require("jquery");
var PNotify = require("pnotify");

$(function(){
    $("#btnShowFrm").click(function(){
        new PNotify({
            title: "Yay!",
            text: "It works!"
        });
    });

    $("#btnShowFrm2").click(function(){
        require("pnotify.reference");

        new PNotify({
            title: "Yay!",
            text: "It works!",
            reference: {
                put_thing: true
            }
        });
    });
});