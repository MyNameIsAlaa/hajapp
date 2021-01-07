<?php
class  Haj
{

    // database connection
    private $conn;


    // constructor with $db as database connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getPackages()
    {
        $stmt = $this->conn->prepare('select * from packages where LastDatetoBook >= curdate() and active = 1');
        $stmt->execute();
        $list = [];
        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] = [
                "ID" => $record['packageId'],
                "Name" => $record['PackageName'],
                "Price" => $record['Price']
            ];
        }
        return $list;
    }



    public function getLocations()
    {
        $stmt = $this->conn->prepare("SELECT * FROM mofa_accommodations");
        $stmt->execute();
        $locations = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $locations[] =   array('id' => $row['id'], 'city' => $row['city'], 'location' => $row['location'], 'lattitude' => $row['lattitude'], 'longitude' => $row['longitude'], 'telephone' => $row['tel']);
        }
        return $locations;
    }


    public function getTitles()
    {
        $stmt = $this->conn->prepare('select * from mofa_title');
        $stmt->execute();
        $list = [];
        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // $list[$record['cnID']] =  $record['title'];
            $list[] =  ["ID" => $record['cnID'], "title" => $record['title']];
        }
        return $list;
    }

    public function getNationalities()
    {
        $stmt = $this->conn->prepare('select * from mofa_country');
        $stmt->execute();
        $list = [];

        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] =  ["ID" => $record['cnID'], "Country" => $record['Country']];
        }
        return $list;
    }

    public function getMarital()
    {
        $stmt = $this->conn->prepare('select * from mofa_MaritalStatus');
        $stmt->execute();
        $list = [];

        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] =  ["ID" => $record['ID'], "status" => $record['marital_status']];
        }
        return $list;
    }


    public function getRelation()
    {
        $stmt = $this->conn->prepare('select * from mofa_relation');
        $stmt->execute();
        $list = [];

        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] =  ["ID" => $record['relID'], "relations" => $record['relation']];
        }
        return $list;
    }


    public function getCountries()
    {
        $stmt = $this->conn->prepare('select * from mofa_Nationalities');
        $stmt->execute();
        $list = [];

        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $list[] =  ["ID" => $record['ID'], "Nationality" => $record['Nationality'], "natcode" => $record['natcode']];
        }
        return $list;
    }


    public function DeletePax($id)
    {
        $stmt = $this->conn->prepare("UPDATE mofa_details SET deleted=1 WHERE historyId=:paxId");
        $stmt->bindParam(':paxId', $id);
        $stmt->execute();
    }


    public function CreateCustomer($customerName, $customerSurname, $package, $email, $password = '')
    {

        try {
            //code...

            $stmt = $this->conn->prepare('insert into mofa_customer (name,surname,airlineId, `arrival date`, makkah_hotel, madina_hotel, deleted, email, password) values (:NAME,:SURENAME,:PACKAGE, NOW(), 0,0,0, :EMAIL, :PASS)');
            $stmt->bindParam(':NAME', $customerName);
            $stmt->bindParam(':SURENAME', $customerSurname);
            $stmt->bindParam(':PACKAGE', $package);
            $stmt->bindParam(':EMAIL', $email);
            $stmt->bindParam(':PASS', $password);
            if (!$stmt->execute()) {
                return $stmt->errorInfo();
            }
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function insertDetails($request)
    {
        try {
            //code...

            $stmt = $this->conn->prepare('insert into mofa_details (CustomerId,Title,Name,Surname,Nationality,Profession,MothersName,PlaceofBirth,DateofBirth,PassportNo,PlaceofIssue,DateofIssue,DateofExpiry,Address,MaritalStatus,sex, deleted, hasVisa,DepartureRoute, ReturnRoute) values(:FamilyID, :Title, :Name, :Surname,:Nationality, :Profession , :MOMname , :POB, :DOB, :passport, :POissue, :DOissue, :DOExpiry, :address , :maritalStatus ,:sex, 0, 0, 0, 0)');
            // $stmt->bindParam(':paxID', $request['paxID']);
            $stmt->bindParam(':FamilyID', $request['familyID']);
            $stmt->bindParam(':Title', $request['title']);
            $stmt->bindParam(':Name', $request['name']);
            $stmt->bindParam(':Surname', $request['surename']);
            $stmt->bindParam(':Nationality', $request['nationality']);
            $stmt->bindParam(':Profession', $request['profession']);
            $stmt->bindParam(':MOMname', $request['mom_name']);
            // $stmt->bindParam(':maleRelation', $request['name']);
            // $stmt->bindParam(':relationship', $request['name']);
            $stmt->bindParam(':POB', $request['POB']);
            $stmt->bindParam(':DOB', $request['DOB']);
            $stmt->bindParam(':passport', $request['passport']);
            $stmt->bindParam(':POissue', $request['authority']);
            $stmt->bindParam(':DOissue', $request['DOI']);
            $stmt->bindParam(':DOExpiry', $request['DOE']);
            $stmt->bindParam(':address', $request['address']);
            $stmt->bindParam(':maritalStatus', $request['marital']);
            $stmt->bindParam(':sex', $request['sex']);
            if (!$stmt->execute()) {
                return $stmt->errorInfo();
            }
            return $this->conn->lastInsertId();  //pxID
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function Save_User_Address($familyId, $address1, $address2 = null, $address3 = null)
    {
        $stmt = $this->conn->prepare("insert into Mofa_customerContact (customerID,type,contactData, created) values (:FAMILYID,'address1',:ADDR1,created, NOW()");
        $stmt->bindParam(':FAMILYID', $familyId);
        $stmt->bindParam(':ADDR1', $address1);
        $stmt->execute();
        if ($address2) {
            $stmt = $this->conn->prepare("insert into Mofa_customerContact (customerID,type,contactData,created) values (:FAMILYID,'address2',:ADDR2, NOW())");
            $stmt->bindParam(':FAMILYID', $familyId);
            $stmt->bindParam(':ADDR2', $address2);
            $stmt->execute();
        }
        if ($address3) {
            $stmt = $this->conn->prepare("insert into Mofa_customerContact (customerID,type,contactData,created) values (:FAMILYID,'address3',:ADDR3, NOW())");
            $stmt->bindparam(':FAMILYID', $familyId);
            $stmt->bindparam(':ADDR3', $address3);
            $stmt->execute();
        }
    }

    public function Save_User_Email($familyId, $email)
    {
        $stmt = $this->conn->prepare("insert into Mofa_customerContact (customerID,type,contactData,created) values (:familyId,'email',:email, NOW())");
        $stmt->bindParam(':familyId', $familyId);
        $stmt->bindParam(':email', $email);
        return $stmt->execute();
    }


    public function Save_User_Phone($familyId, $phone)
    {
        $stmt = $this->conn->prepare("insert into Mofa_customerContact (customerID,type,contactData,created) values (:familyId,'phone',:phone, NOW())");
        $stmt->bindParam(':familyId', $familyId);
        $stmt->bindParam(':phone', $phone);
        return $stmt->execute();
    }

    public function Save_User_Mobile($familyId, $mobile)
    {
        $stmt = $this->conn->prepare("insert into Mofa_customerContact (customerID,type,contactData,created) values (:familyId,'mobile',:mobile, NOW())");
        $stmt->bindParam(':familyId', $familyId);
        $stmt->bindParam(':mobile', $mobile);
        return $stmt->execute();
    }


    public function getCustomers($familyID)
    {
        $stmt = $this->conn->prepare("SELECT *
FROM mofa_customer c
LEFT JOIN mofa_details d ON c.custID = d.CustomerId     
LEFT JOIN mofa_Nationalities n ON d.Nationality = n.natcode
LEFT JOIN `mofa_MaritalStatus` m ON m.ID = d.MaritalStatus
LEFT JOIN mofa_relation r ON d.Relationship = r.relID   
where  c.deleted =0 AND d.deleted =0 AND CustomerId=:familyId ");
        $stmt->bindParam(":familyId", $familyID);
        $stmt->execute();
        $passengers = [];
        //return print_r($stmt->fetch(PDO::FETCH_ASSOC));
        while ($record = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $passengers[] =  ["id" => $record['paxId'], "title" => $record['Title'], "name" => $record['Name'], 'surname' => $record['Surname'], 'PassportNo' => $record['PassportNo'], 'email' => $record['email']];
        }
        return ['data' => $passengers];
    }


    public function getPax($paxID)
    {
        $stmt = $this->conn->prepare("SELECT * FROM mofa_details WHERE paxId=:paxID");
        $stmt->bindParam(":paxID", $paxID);
        $stmt->execute();
        //$passenger = [];
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePax($request)
    {
        $stmt = $this->conn->prepare("UPDATE mofa_details SET name=:name  WHERE  paxId=:paxID");
        $stmt->bindParam(":paxID", $request['paxID']);
        $stmt->bindParam(":name", $request['name']);
        $stmt->execute();
    }


    public function login($email, $password)
    {
        $stmt = $this->conn->prepare("SELECT * FROM mofa_customer WHERE email=:EMAIL AND password=:PASS");
        $stmt->bindParam(':EMAIL', $email);
        $stmt->bindParam(':PASS', $password);
        $stmt->execute();
        if ($stmt->rowCount() >= 1) {
            return true;
        } else {
            return false;
        }
    }



    public function getMessages()
    {
        $stmt = $this->conn->prepare("SELECT * FROM mofa_messages WHERE deleted = 0");
        $stmt->execute();
        $messages = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $messages[] =   array('Message' => $row['message'], 'created' => $row['created']);
        }
        return $messages;
    }

    public function InsertMessage($message)
    {
        $stmt = $this->conn->prepare("INSERT INTO mofa_messages 
        (message, created) value (:MSG, NOW())");
        $stmt->bindParam(':MSG', $message);
        $stmt->execute();
    }


    public function DeleteMessages()
    {
        $stmt = $this->conn->prepare("DELETE FROM mofa_messages");
        $stmt->execute();
    }
}
