/*
Project: Facebook, Twitter & Linkedin Status Update
Author: Md. Mahmud Ahsan (http://thinkdiff.net)
version: 1.0
Date: 24-03-2010
Description: This is a open source php, jquery, fbconnect and facebook api base photo gallery.
             Using this application you'll see the latest photos of your friends in facebook.
             Here Facebook connect is used for login purpose and facebook api is used to retrieve your friends
             latest photos from facebook. Jquery is used to create user friendly UI and photo gallery.

Copyright (C) 2010  Md. Mahmud Ahsan (mahmud@thinkdiff.net)

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.


/* All the javascript functions should be here */
//facebook connect functionalities
function fbcloggedin(){
    $('#login').css('display', 'none');
    $('#logout').css('display', 'block');
}

function fbcloggedout(){
    FB.ensureInit(function() {
        FB.Connect.logout(function() {
                $('#login').css('display', 'block');
                $('#logout').css('display', 'none');
        });
    });
}

function ajaxCall(){
    var status = $('#status').val();
    var datas  = "status=" + status;
    $("#loader").css('display', 'block');

    $.ajax({
      url: baseUrl + "/statusupdate.php",
      type: "POST",
      data: datas,
      success: function(html){
        $("#loader").css('display', 'none');
        $("#result").html(html);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown){
          alert("Error occured");
      }
    });
}
