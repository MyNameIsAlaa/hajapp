$(document).ready(function () {

    $('.dateinput').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('.dateinput1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });
    $('.dateinput2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd'
    });

    if (typeof (familyID) !== 'undefined') {
        renderTable(familyID);
    }
    if (typeof (paxID) !== 'undefined') {
        getPax(paxID);
    }

    //   $('#step2').hide();
    $('#alert_box').hide();
    //   $('#step1').show();

    // process the form
    $('#signup_form').submit(function (event) {

        event.preventDefault();

        var $inputs = $('#signup_form :input');
        var formData = {};
        $inputs.each(function () {
            formData[this.name] = $(this).val();
        });


        Form1Obj = formData; //save data for step2 submit

        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '../app.php?action=signup', // the url where we want to POST
            data: formData, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        })
            .done(function (data) {


                if (typeof data['errors'] !== 'undefined') {
                    $("#alert_box .alert_message").html("");
                    for (let index = 0; index < data['errors'].length; index++) {
                        $("#alert_box .alert_message").append(data['errors'][index] + "</br>");
                    }
                    $("#alert_box").show();
                }

                if (data['status'] == 'success' && typeof data['familyId'] !== 'undefined') {
                    $("#step1").hide();
                    $("#step2").show();
                    familyID = data['familyId'];
                } else {
                    $("#alert_box .alert_message").html("Error submitting the form please contact support!");
                }


            });


    });



    // process the form
    $('#signup_form2').submit(function (event) {

        event.preventDefault();

        if (typeof (paxID) == 'undefined') {
            insertPax()
        } else {
            updatePax()
        }



    });


    function renderTable(familyID) {
        table = $('#passengers').DataTable({
            "ajax": '../app.php?action=getCustomers&familyID=' + familyID,
            "columns": [
                //  { "data": "id" },
                { "data": "name" },
                { "data": "surname" },
                { "data": "PassportNo" },
                {
                    "data": null,
                    "defaultContent": '<button type="button" class="editbutton">Edit</button><button type="button" class="delbutton">Delete</button>'
                }
            ],
            "destroy": true,
            "searching": false,
            "paging": false
        });
    }


    function getPax(paxID) {

        $.ajax({
            type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
            url: '../app.php?action=getPax&paxID=' + paxID, //the url where we want to POST
            dataType: 'json', // what type of data do we expect back from the server
            encode: true
        }).done(function (data) {
            console.log(data);
            $('#profession').val(data['Profession']);
            $('#mom_name').val(data['MothersName']);
            $('#name2').val(data['Name']);
            $('#surename2').val(data['Surname']);
            $('#title').val(data['Title']);
            $('#passport').val(data['PassportNo']);
            $('#POB').val(data['PlaceofBirth']);
            $('#DOB').val(data['DateofBirth']);
            $('#authority').val(data['PlaceofIssue']);
            $('#DOE').val(data['DateofExpiry']);
            $('#DOI').val(data['DateofIssue']);
            $('#sex').val(data['SEX']);
        });

    }

    function insertPax() {


        var $inputs = $('#signup_form2 :input');
        var formData = {};
        $inputs.each(function () {
            formData[this.name] = $(this).val();
        });

        formData['name'] = $('#name2').val();
        formData['surename'] = $('#surename2').val();
        formData['familyID'] = familyID;


        // process the form
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '../app.php?action=signup2', // the url where we want to POST
            data: formData, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true,
        })
            .done(function (data) {


                if (typeof data['errors'] !== 'undefined') {
                    $("#alert_box .alert_message").html("");
                    for (let index = 0; index < data['errors'].length; index++) {
                        $("#alert_box .alert_message").append(data['errors'][index] + "</br>");
                    }
                    $("#alert_box").show();
                }
                if (data['status'] == 'success' && typeof data['pxID'] !== 'undefined') {
                    uploadImage(data['pxID']);
                    $("#alert_box .alert_message").html("Passenger has been added successfully!");
                    renderTable(formData['familyID']);
                } else {
                    $("#alert_box .alert_message").html("Error submitting the form please contact support!");
                }

            });

    }




    function updatePax() {


        var $inputs = $('#signup_form2 :input');
        var formData = {};
        $inputs.each(function () {
            formData[this.name] = $(this).val();
        });

        formData['name'] = $('#name2').val();
        formData['surename'] = $('#surename2').val();
        formData['familyID'] = familyID;
        formData['paxID'] = paxID;
        // process the form
        console.log(formData);
        $.ajax({
            type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url: '../app.php?action=updatePax', // the url where we want to POST
            data: formData, // our data object
            dataType: 'json', // what type of data do we expect back from the server
            encode: true,
            // processData: false,
            // contentType: false,
        })
            .done(function (data) {


                if (typeof data['errors'] !== 'undefined') {
                    $("#alert_box .alert_message").html("");
                    for (let index = 0; index < data['errors'].length; index++) {
                        $("#alert_box .alert_message").append(data['errors'][index] + "</br>");
                    }
                    $("#alert_box").show();
                }
                if (data['status'] == 'success' && typeof data['pxID'] !== 'undefined') {
                    uploadImage(data['pxID']);
                    $("#alert_box .alert_message").html("Passenger has been added successfully!");
                    renderTable(formData['familyID']);
                } else {
                    $("#alert_box .alert_message").html("Error submitting the form please contact support!");
                }

            });

    }

    $('#passengers').on('click', '.editbutton', function () {
        var data = table.row($(this).parents('tr')).data();
        window.location = "index.php?paxID=" + data['id'] + '&familyID=' + familyID;
    });


    $('#passengers').on('click', '.delbutton', function () {
        var data = table.row($(this).parents('tr')).data();
        $.ajax({
            type: 'GET',
            url: '../app.php?action=deletePax&paxid=' + data['id'],
            contentType: false,
            processData: false,
            success: function (response) {
                if (familyID) renderTable(familyID);
            }
        });
    });



    function uploadImage(paxID) {
        var fileName = paxID + "-" + $("#passport").val();
        var file_data = $('.image').prop('files')[0];
        if (file_data != undefined) {
            var form_data = new FormData();
            form_data.append('file', file_data);
            $.ajax({
                type: 'POST',
                url: '../app.php?action=uploadImage&fileName=' + fileName,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    $('.image').val('');
                }
            });
        }
    }


    // get packages
    $.post("../app.php?action=getPackges", {},
        function (data) {
            // console.log(data);
            var sel = $("#packages");
            sel.empty();
            for (var i = 0; i < data.length; i++) {
                sel.append('<option value="' + data[i].ID + '">' + data[i].Name + '</option>');
            }
        }, "json");


    // get Nationalities
    $.post("../app.php?action=getNationalities", {},
        function (data) {
            // console.log(data);
            var sel = $("#Nationality");
            sel.empty();
            for (var i = 0; i < data.length; i++) {
                sel.append('<option value="' + data[i].ID + '">' + data[i].Country + '</option>');
            }
        }, "json");


    // get Marital
    $.post("../app.php?action=getMarital", {},
        function (data) {
            var sel = $("#Marital");
            sel.empty();
            for (var i = 0; i < data.length; i++) {
                sel.append('<option value="' + data[i].ID + '">' + data[i].status + '</option>');
            }
        }, "json");

    // get Titles
    $.post("../app.php?action=getTitles", {},
        function (data) {
            var sel = $("#Titles");
            sel.empty();
            for (var i = 0; i < data.length; i++) {
                sel.append('<option value="' + data[i].ID + '">' + data[i].title + '</option>');
            }
        }, "json");


});