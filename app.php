<?php

// Enable CROS - THIS IS OPTIONAL IF WE HAVE CROS ERRORS
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


header('Content-Type: application/json');


require("config.php"); // db and other settings
require("database.php"); // db connection 
require("misc.php"); // miscellaneous class and functions
require("input.php"); // input validation class
require("haj.php"); // haj class
require('fcm.php');

//if json request decode it, if not then use normal $_POST;
$postdata = file_get_contents("php://input");
$request = (json_decode($postdata) != NULL) ? $request = json_decode($postdata, true) : $request = $_POST;



$database = new Database();
$connection = $database->getConnection();
$database->createTables();
$Misc = new Misc();
$Haj = new Haj($connection);
$FCM = new FCM();


isset($_GET['action']) ? $action = $_GET['action'] : $action = "";

switch ($action) {

    case 'getPackges':
        echo json_encode($Haj->getPackages());
        break;

    case 'getTitles':
        echo json_encode($Haj->getTitles());
        break;

    case 'getNationalities':
        echo json_encode($Haj->getNationalities());
        break;

    case 'getCountries':
        echo json_encode($Haj->getCountries());
        break;

    case 'getMarital':
        echo json_encode($Haj->getMarital());
        break;


    case 'getRelation':
        echo json_encode($Haj->getRelation());
        break;

    case 'getMessages':
        echo json_encode($Haj->getMessages());
        break;


    case 'getLocations':
        echo json_encode($Haj->getLocations());
        break;

    case 'getPax':
        if (!isset($_REQUEST['paxID'])) {
            echo json_encode(["error" => "PAX ID is required!"]);
        } else {
            $paxID = (int) $_REQUEST['paxID'];
            echo  json_encode($Haj->getPax($paxID));
        }
        break;

    case 'getCustomers':
        if (!isset($_REQUEST['familyID'])) {
            echo json_encode(["error" => "family ID is required!"]);
        } else {
            $familyID = $_REQUEST['familyID'];
            echo  json_encode($Haj->getCustomers($familyID));
        }
        break;

    case 'sendMessage':
        // save message to db;
        $errors = Input::check(['message'], $request);
        if ($errors) die(json_encode(["errors" => $errors]));
        $Haj->InsertMessage($request['message']);
        //send push notification with FCM
        $FCM->sendMessage($request['message']);
        echo json_encode(["status" => "success", "message" => "message was sent successfully!"]);
        break;


    case 'deleteMessages':
        $Haj->DeleteMessages();
        break;

    case 'signup':

        $errors = Input::check(['name', 'surename'], $request);
        if ($errors) die(json_encode(["errors" => $errors]));

        isset($request['password']) ? $password = $request['password'] : $password = $Misc->Generate_Password(6);

        (int) $familyId = $Haj->CreateCustomer($request['name'], $request['surename'], (int) $request['package'], $request['email'], md5($password), '');
        if ($familyId) {
            $Haj->Save_User_Address($familyId, $request['address1']);
            $Haj->Save_User_Email($familyId, $request['email']);
            $Haj->Save_User_Phone($familyId, $request['phone']);
            $Haj->Save_User_Mobile($familyId, $request['mobile']);
            echo json_encode(["status" => "success", "familyId" => $familyId]);
        } else {
            echo json_encode(["status" => "error", "message" => "couldn't create new user"]);
        }
        break;



    case 'signup2':

        $errors = Input::check(['profession', 'mom_name', 'title', 'passport', 'POB', 'DOB', 'authority', 'nationality', 'sex', 'DOI', 'DOE', 'name', 'surename'], $request);
        if ($errors) die(json_encode(["errors" => $errors]));


        if (!isset($request['familyID'])) {
            (int) $request['familyID'] = $Haj->CreateCustomer($request['name'], $request['surename'], (int) $request['package'], $request['email']);
        }


        $paxID = $Haj->insertDetails($request);


        if ($paxID) {
            echo json_encode(["status" => "success", "pxID" => $paxID]);
        } else {
            //error
            echo json_encode(["status" => "error", "message" => "couldn't create new passenger"]);
        }
        break;


    case 'updatePax':
        //   echo json_decode(print_r($request));
        if (!isset($request['paxID'])) {
            echo json_encode(["error" => "PAX ID is required!"]);
        } else {
            $Haj->updatePax($request);
            echo json_encode(["status" => "success"]);
        }
        break;

    case 'deletePax':
        if (!isset($_REQUEST['paxid'])) return;
        $paxID = ($_REQUEST['paxid']);
        $Haj->DeletePax($paxID);
        echo json_encode(["status" => "success"]);
        break;

    case 'uploadImage':

        $path = $_FILES['file']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $fileName = $_GET['fileName'];

        if (!file_exists('uploads')) {
            mkdir('uploads', 0777);
        }

        $allowed_types = array("application/pdf", "image/jpeg", "image/png", "image/bmp", "image/gif");
        if (!in_array($_FILES["file"]["type"], $allowed_types)) {
            echo json_encode(["status" => "error", "message" => "file type is not allowed!"]);
        } else {
            $neWfileName = $fileName . "." . $ext;
            if (move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $neWfileName)) {
                echo json_encode(["status" => 'success', "file" => $neWfileName]);
            } else {
                echo json_encode(["status" => "error", "message" => "couldn't upload file"]);
            }
        }


        break;



    case 'login':
        $errors = Input::check(['email', 'password'], $request);
        if ($errors) die(json_encode(["errors" => $errors]));
        $status = $Haj->login($request['email'], md5($request['password']));
        if ($status) {
            echo json_encode(["status" => "success", "message" => "you have successfully logged in"]);
        } else {
            echo json_encode(["status" => "error", "message" => "username or password is wrong"]);
        }
        break;



    default:
        echo json_encode(["status" => "error", "message" => "Action was not found!"]);
        break;
}
