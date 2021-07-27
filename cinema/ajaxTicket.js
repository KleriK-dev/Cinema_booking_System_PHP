$(document).ready(function(){

    $("#inputGroupSelectMovie").change(function(){ //when the change event happens to the movie selection replace all the other fields

        var movieName = $("#inputGroupSelectMovie").val(); //get movie value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectRoom.php?movie=" + movieName, false);
        xmlhttp.send();
        $("#inputGroupSelectRoom").html(xmlhttp.responseText); //set room values on the room field

        var roomName = $("#inputGroupSelectRoom").val(); //get room value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectDate.php?movie=" + movieName + "&room=" + roomName, false);
        xmlhttp.send();
        $("#inputGroupSelectDate").html(xmlhttp.responseText); //set date values on date field

        var scheduleDate = $("#inputGroupSelectDate").val(); //get date value 
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectTime.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate, false);
        xmlhttp.send();
        $("#inputGroupSelectTime").html(xmlhttp.responseText); //set time values on time field

        var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectSeats.php?room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
        xmlhttp.send();
        $("#createSeats").html(xmlhttp.responseText); //create seats

    });
        
        $("#inputGroupSelectRoom").change(function(){ //if room value is changed

            var movieName = $("#inputGroupSelectMovie").val(); //get movie value

            var roomName = $("#inputGroupSelectRoom").val(); //get this value
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectDate.php?movie=" + movieName + "&room=" + roomName, false);
            xmlhttp.send();
            $("#inputGroupSelectDate").html(xmlhttp.responseText); //set the new date value on value field

            var scheduleDate = $("#inputGroupSelectDate").val(); //get the changed date value 
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectTime.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate, false);
            xmlhttp.send();
            $("#inputGroupSelectTime").html(xmlhttp.responseText); //set time values on time field

            var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectSeats.php?room=" + roomName  + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
            xmlhttp.send();
            $("#createSeats").html(xmlhttp.responseText); //create seats

        });

        $("#inputGroupSelectDate").change(function(){ //if date value is changed

            var movieName = $("#inputGroupSelectMovie").val(); //get movie value
            var roomName = $("#inputGroupSelectRoom").val(); //get this value

            var scheduleDate = $("#inputGroupSelectDate").val(); //get this value
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectTime.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate, false);
            xmlhttp.send();
            $("#inputGroupSelectTime").html(xmlhttp.responseText); //set new time value on value field

            var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectSeats.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
            xmlhttp.send();
            $("#createSeats").html(xmlhttp.responseText); //create seats

        });

        $("#inputGroupSelectTime").change(function(){ //if time value is changed

            var roomName = $("#inputGroupSelectRoom").val(); //get this value
            var scheduleDate = $("#inputGroupSelectDate").val(); //get this value

            var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectSeats.php?room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
            xmlhttp.send();
            $("#createSeats").html(xmlhttp.responseText); //create seats

        });
    

    
    $("#inputGroupSelectMovie option").each(function() { //check default selected values after pressing book now button or edit
        if(this.selected){

            var roomName = $("#inputGroupSelectRoom").val(); //get room value
            var scheduleDate = $("#inputGroupSelectDate").val(); //get date value 
            var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema/ajaxQueries/selectSeats.php?room=" + roomName  + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
            xmlhttp.send();
            $("#createSeats").html(xmlhttp.responseText); //create seats

        } 
              
    });

});