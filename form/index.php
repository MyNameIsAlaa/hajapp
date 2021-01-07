<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/css/gijgo.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div id="alert_box" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong class="alert_message"></strong>
                </div>
            </div>
        </div>

        <div id="step1" class="row">
            <div class="col-12">
                <form id="signup_form">
                    <div class="form-group">
                        <label for="first name">First Name:</label>
                        <input required type="text" name="name" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="surename">Surename:</label>
                        <input required type="text" class="form-control" name="surename" id="surename">
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail:</label>
                        <input required type="email" class="form-control" name="email" id="email">
                    </div>

                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input required type="password" class="form-control" name="password" id="password">
                    </div>

                    <div class="form-group">
                        <label for="package">Package:</label>
                        <select required id="packages" class="form-control" name="package" id="package">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="phone">phone:</label>
                        <input required type="number" class="form-control" name="phone" id="phone">
                    </div>

                    <div class="form-group">
                        <label for="mobile">mobile:</label>
                        <input required type="number" class="form-control" name="mobile" id="mobile">
                    </div>

                    <div class="form-group">
                        <label for="address">address1:</label>
                        <input required type="text" class="form-control" name="address1" id="address1">
                    </div>

                    <button type="submit" class="btn btn-primary">Next</button>
                </form>

            </div>
        </div>
        <div id="step2" class="row">
            <div class="col-12">


                <form id="signup_form2">

                    <div class="form-group">
                        <h3>Step 2</h3>
                    </div>

                    <div class="form-group">
                        <label for="Profession">Profession*:</label>
                        <input class="form-control" type="text" id="profession" name="profession">
                    </div>

                    <div class="form-group">
                        <label for="mom_name">Mother's name*:</label>
                        <input class="form-control" type="text" id="mom_name" name="mom_name">
                    </div>


                    <div class="form-group">
                        <label for="name">Name*:</label>
                        <input class="form-control" type="text" id="name2" name="name">
                    </div>

                    <div class="form-group">
                        <label for="surename">Surename*:</label>
                        <input class="form-control" type="text" id="surename2" name="surename">
                    </div>


                    <div class="form-group">
                        <label for="title">Titles*:</label>
                        <select required id="Titles" class="form-control" name="title">
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="passport">Passport number*:</label>
                        <input type="text" required id="passport" class="form-control" name="passport">
                    </div>

                    <div class="form-group">
                        <label for="POB">POB*:</label>
                        <input type="text" class="form-control" required id="POB" class="form-control" name="POB">
                    </div>


                    <div class="form-group">
                        <label for="authority">Issuing Authority*: :</label>
                        <input class="form-control" type="text" id="authority" name="authority">
                    </div>


                    <div class="form-group">
                        <label for="Nationality">Nationality*:</label>
                        <select required id="Nationality" class="form-control" name="nationality">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Sex">Sex*:</label>
                        <select required id="sex" class="form-control" name="sex">
                            <option value="1">male</option>
                            <option value="2">female</option>

                        </select>
                    </div>

                    <div class="form-group">
                        <label for="marital">Marital*:</label>
                        <select required id="Marital" class="form-control" name="marital">
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Date of birth*:</label>
                        <input name="DOB" id="DOB" class="dateinput" width="276">
                    </div>

                    <div class="form-group">
                        <label for="">Date of issue*:</label>
                        <input name="DOI" id="DOI" class="dateinput1" width="276">

                    </div>

                    <div class="form-group">
                        <label for="">Date of expiry*:</label>
                        <input name="DOE" id="DOE" class="dateinput2" width="276">

                    </div>

                    <div class="form-group">
                        <label for="">Passport image:</label>
                        <input type="file" class="form-control-file image" name="file" id="file" aria-describedby="fileHelpId">
                    </div>

                    <button type="submit" class="btn btn-primary">Add Passenger</button>
                </form>




                <table id="passengers" class="display" style="width:100%">
                    <thead>
                        <tr>

                            <th>name</th>
                            <th>surename</th>
                            <th>Passport No.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>

                            <th>name</th>
                            <th>surename</th>
                            <th>Passport No.</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>

                <button type="button" id="confrimComplete" class="btn btn-primary">Confirm</button>


            </div>
        </div>
    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.13/combined/js/gijgo.min.js "></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>

    <script>
        var familyID, Form1Obj;
    </script>
    <?php if (isset($_REQUEST['familyID']) || isset($_REQUEST['paxID'])) { ?>
        <script>
            $(document).ready(function() {
                $("#step1").hide();
                $("#step2").show();
                <?php if (isset($_REQUEST['familyID'])) { ?>
                    familyID = <?php echo $_REQUEST['familyID'];
                            } else { ?> undefined;
                <?php } ?>;
                <?php if (isset($_REQUEST['paxID'])) { ?>
                    paxID = <?php echo $_REQUEST['paxID'];
                        } else { ?> undefined;
                <?php } ?>;
            })
        </script>
    <?php } else { ?>
        <script>
            $(document).ready(function() {
                $("#step2").hide();
                $("#step1").show();
            })
        </script>
    <?php } ?>
    <script src="form.js"></script>
</body>

</html>