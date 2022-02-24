<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * PHP version 5.4
 */
class DraftmediaVisits extends \Core\Model
{
    static $DB_TABLE_NAME = 'draftmedia_visits';

    /**
     * IMPORTANT: If the number of values contained within "$TABLE_VALUES" changes, then you will
     * also need to change the position values of method "checkDraftmediaDate()" from class
     * "\Core\Visitors".
     *
     * @var array
     */
    static $TABLE_VALUES =
        [
            0 => "id",

            1 => "Aboutus_index_anonym_visits",
            2 => "Aboutus_index_auth_visits",
            3 => "Aboutus_index_anonym_time",
            4 => "Aboutus_index_auth_time",

            5 => "CompanyPolitics_privacyPolitics_anonym_visits",
            6 => "CompanyPolitics_privacyPolitics_auth_visits",
            7 => "CompanyPolitics_privacyPolitics_anonym_time",
            8 => "CompanyPolitics_privacyPolitics_auth_time",

            9 => "CompanyPolitics_termsAndConditions_anonym_visits",
            10 => "CompanyPolitics_termsAndConditions_auth_visits",
            11 => "CompanyPolitics_termsAndConditions_anonym_time",
            12 => "CompanyPolitics_termsAndConditions_auth_time",

            13 => "Dea_uploadFiles_anonym_visits",
            14 => "Dea_uploadFiles_auth_visits",
            15 => "Dea_uploadFiles_anonym_time",
            16 => "Dea_uploadFiles_auth_time",

            17 => "Dea_index_anonym_visits",
            18 => "Dea_index_auth_visits",
            19 => "Dea_index_anonym_time",
            20 => "Dea_index_auth_time",

            21 => "Home_index_anonym_visits",
            22 => "Home_index_auth_visits",
            23 => "Home_index_anonym_time",
            24 => "Home_index_auth_time",

            25 => "Login_index_anonym_visits",
            26 => "Login_index_auth_visits",
            27 => "Login_index_anonym_time",
            28 => "Login_index_auth_time",

            29 => "Pricing_index_anonym_visits",
            30 => "Pricing_index_auth_visits",
            31 => "Pricing_index_anonym_time",
            32 => "Pricing_index_auth_time",

            33 => "Register_index_anonym_visits",
            34 => "Register_index_auth_visits",
            35 => "Register_index_anonym_time",
            36 => "Register_index_auth_time",

            37 => "Services_index_anonym_visits",
            38 => "Services_index_auth_visits",
            39 => "Services_index_anonym_time",
            40 => "Services_index_auth_time",

            41 => "UserProfile_index_anonym_visits",
            42 => "UserProfile_index_auth_visits",
            43 => "UserProfile_index_anonym_time",
            44 => "UserProfile_index_auth_time",

            45 => "UserRequests_index_anonym_visits",
            46 => "UserRequests_index_auth_visits",
            47 => "UserRequests_index_anonym_time",
            48 => "UserRequests_index_auth_time",

            49 => "max_users_online",
            50 => "current_users_online",
            51 => "number_of_sessions",
            52 => "date"
        ];

    private $id;
    private $Aboutus_index_anonym_visits;
    private $Aboutus_index_auth_visits;
    private $Aboutus_index_anonym_time;
    private $Aboutus_index_auth_time;
    private $CompanyPolitics_privacyPolitics_anonym_visits;
    private $CompanyPolitics_privacyPolitics_auth_visits;
    private $CompanyPolitics_privacyPolitics_anonym_time;
    private $CompanyPolitics_privacyPolitics_auth_time;
    private $CompanyPolitics_termsAndConditions_anonym_visits;
    private $CompanyPolitics_termsAndConditions_auth_visits;
    private $CompanyPolitics_termsAndConditions_anonym_time;
    private $CompanyPolitics_termsAndConditions_auth_time;
    private $Dea_uploadFiles_anonym_visits;
    private $Dea_uploadFiles_auth_visits;
    private $Dea_uploadFiles_anonym_time;
    private $Dea_uploadFiles_auth_time;
    private $Dea_index_anonym_visits;
    private $Dea_index_auth_visits;
    private $Dea_index_anonym_time;
    private $Dea_index_auth_time;
    private $Home_index_anonym_visits;
    private $Home_index_auth_visits;
    private $Home_index_anonym_time;
    private $Home_index_auth_time;
    private $Login_index_anonym_visits;
    private $Login_index_auth_visits;
    private $Login_index_anonym_time;
    private $Login_index_auth_time;
    private $Pricing_index_anonym_visits;
    private $Pricing_index_auth_visits;
    private $Pricing_index_anonym_time;
    private $Pricing_index_auth_time;
    private $Register_index_anonym_visits;
    private $Register_index_auth_visits;
    private $Register_index_anonym_time;
    private $Register_index_auth_time;
    private $Services_index_anonym_visits;
    private $Services_index_auth_visits;
    private $Services_index_anonym_time;
    private $Services_index_auth_time;
    private $UserProfile_index_anonym_visits;
    private $UserProfile_index_auth_visits;
    private $UserProfile_index_anonym_time;
    private $UserProfile_index_auth_time;
    private $UserRequests_index_anonym_visits;
    private $UserRequests_index_auth_visits;
    private $UserRequests_index_anonym_time;
    private $UserRequests_index_auth_time;
    private $max_users_online;
    private $current_users_online;
    private $number_of_sessions;
    private $date;


    /**
     * This method retrieves all the content of this table's database and returns it as an array.
     * Additionally and optionally, you can define a desired order for the retrieved data. To define a desired order,
     * you must specify the column's literal name as an string in the arguments of this method.
     *
     * @param array $orderedBy
     * @return mixed
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE September 18, 2018
     */
    public static function findAll($orderedBy=[])
    {
        if (empty($orderedBy)) {
            $orderedBy = 'id';
        }
        try {
            $thisTable = static::$DB_TABLE_NAME;
            $db = static::getDB();
            $stmt = $db->query("SELECT * FROM $thisTable ORDER BY $orderedBy");
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch(\PDOException $e)
        {
            throw new \Exception(new \Core\Dump($e));
        }
    }

    /**
     * This method returns, in an array, the matching row of the id (of this table of the database) that was specified
     * through this method's argument. Consider that the id, on arguments, must be specified as an integer value
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE September 18, 2018
     */
    public static function find($id)
    {
        try {
            $thisTable = static::$DB_TABLE_NAME;
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM $thisTable WHERE id=:id");
            $stmt->execute([
                ":id" => $id
            ]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;

        } catch(\PDOException $e)
        {
            throw new \Exception(new \Core\Dump($e));
        }
    }

    /**
     * This method allows us to find a matching row but, instead of finding a match with an id, the matching value
     * is a customized value of any column (only 1 column at a time) we desired.
     * To use this method, you must specify the column name that you want to use to make a match with this table of our
     * database and then you must specify the specific value from whom you want a match. All this must be specified
     * on this method's argument as an array value in the form of "key=>value"
     * ("column name" => "value that we want to make a match with")
     *
     * @param array $options
     * @return mixed
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE September 18, 2018
     */
    public static function findBy($options=[])
    {
        try {
            $thisTable = static::$DB_TABLE_NAME;
            $db = static::getDB();
            $stmt = $db->prepare("SELECT * FROM $thisTable WHERE ".key($options)."=:".key($options));
            $stmt->execute([
                ":".key($options) => $options[key($options)]
            ]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        } catch(\PDOException $e)
        {
            throw new \Exception(new \Core\Dump($e));
        }
    }

    /**
     * This method is in charge of inserting new brand row values to this table or, if the intention is to update
     * an already existing row, then its values are updated only for the cells that require an update according to
     * the object that has been inputed to this method ($object).
     *
     * @param $object
     * @throws \Exception
     *
     * @author Miranda Meza César
     * DATE September 22, 2018
     */
    public static function persistAndFlush($object)
    {
        $thisTable = static::$DB_TABLE_NAME;
        $db = static::getDB();
        $i=0;
        $data=[];
        foreach ((array)$object as $value) {
            $data[$i]=$value;
            $i++;
        }
        $tv= static::$TABLE_VALUES;

        // Evaluate if the data is an Insert or Uplaod type and then do it
        if ($data[0] == null) {
            //insert
            try {
                $resultadoPreparado = $db->prepare("INSERT INTO $thisTable($tv[0],$tv[1],$tv[2],$tv[3],$tv[4],$tv[5],$tv[6],$tv[7],$tv[8],$tv[9],$tv[10],$tv[11],$tv[12],$tv[13],$tv[14],$tv[15],$tv[16],$tv[17],$tv[18],$tv[19],$tv[20],$tv[21],$tv[22],$tv[23],$tv[24],$tv[25],$tv[26],$tv[27],$tv[28],$tv[29],$tv[30],$tv[31],$tv[32],$tv[33],$tv[34],$tv[35],$tv[36],$tv[37],$tv[38],$tv[39],$tv[40],$tv[41],$tv[42],$tv[43],$tv[44],$tv[45],$tv[46],$tv[47],$tv[48],$tv[49],$tv[50],$tv[51],$tv[52]) VALUES (:$tv[0],:$tv[1],:$tv[2],:$tv[3],:$tv[4],:$tv[5],:$tv[6],:$tv[7],:$tv[8],:$tv[9],:$tv[10],:$tv[11],:$tv[12],:$tv[13],:$tv[14],:$tv[15],:$tv[16],:$tv[17],:$tv[18],:$tv[19],:$tv[20],:$tv[21],:$tv[22],:$tv[23],:$tv[24],:$tv[25],:$tv[26],:$tv[27],:$tv[28],:$tv[29],:$tv[30],:$tv[31],:$tv[32],:$tv[33],:$tv[34],:$tv[35],:$tv[36],:$tv[37],:$tv[38],:$tv[39],:$tv[40],:$tv[41],:$tv[42],:$tv[43],:$tv[44],:$tv[45],:$tv[46],:$tv[47],:$tv[48],:$tv[49],:$tv[50],:$tv[51],:$tv[52])");
                $resultadoPreparado->bindParam(':'.$tv[0], $data[0], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[1], $data[1], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[2], $data[2], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[3], $data[3], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[4], $data[4], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[5], $data[5], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[6], $data[6], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[7], $data[7], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[8], $data[8], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[9], $data[9], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[10], $data[10], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[11], $data[11], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[12], $data[12], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[13], $data[13], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[14], $data[14], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[15], $data[15], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[16], $data[16], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[17], $data[17], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[18], $data[18], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[19], $data[19], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[20], $data[20], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[21], $data[21], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[22], $data[22], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[23], $data[23], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[24], $data[24], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[25], $data[25], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[26], $data[26], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[27], $data[27], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[28], $data[28], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[29], $data[29], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[30], $data[30], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[31], $data[31], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[32], $data[32], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[33], $data[33], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[34], $data[34], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[35], $data[35], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[36], $data[36], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[37], $data[37], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[38], $data[38], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[39], $data[39], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[40], $data[40], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[41], $data[41], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[42], $data[42], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[43], $data[43], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[44], $data[44], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[45], $data[45], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[46], $data[46], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[47], $data[47], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[48], $data[48], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[49], $data[49], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[50], $data[50], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[51], $data[51], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[52], $data[52]);
                $resultadoPreparado->execute();
            } catch(\PDOException $e)
            {
                throw new \Exception(new \Core\Dump($e));
            }
        } else {
            //update
            try {
                $existingObject = DraftmediaVisits::find($data[0])[0];
                $i=0;
                $existingData=[];
                foreach ((array)$existingObject as $value) {
                    $existingData[$i]=$value;
                    $i++;
                }
                for ($i=0; $i<count($existingObject); $i++) {
                    if ($i!=0) {
                        if ($existingObject[$tv[$i]] != $data[$i]) {
                            // If there is a new/different value than the one that already exists, update it
                            $resultadoPreparado = $db->prepare("UPDATE $thisTable SET $tv[$i]=:$tv[$i] WHERE $tv[0]=:id");
                            $resultadoPreparado->bindParam(':'.$tv[$i], $data[$i]);
                            $resultadoPreparado->bindParam(':'."id", $existingData[0]);
                            $resultadoPreparado->execute();
                        }
                    }
                }
            } catch(\PDOException $e)
            {
                throw new \Exception(new \Core\Dump($e));
            }
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAboutusIndexAnonymVisits()
    {
        return $this->Aboutus_index_anonym_visits;
    }

    /**
     * @param mixed $Aboutus_index_anonym_visits
     */
    public function setAboutusIndexAnonymVisits($Aboutus_index_anonym_visits)
    {
        $this->Aboutus_index_anonym_visits = $Aboutus_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getAboutusIndexAuthVisits()
    {
        return $this->Aboutus_index_auth_visits;
    }

    /**
     * @param mixed $Aboutus_index_auth_visits
     */
    public function setAboutusIndexAuthVisits($Aboutus_index_auth_visits)
    {
        $this->Aboutus_index_auth_visits = $Aboutus_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getAboutusIndexAnonymTime()
    {
        return $this->Aboutus_index_anonym_time;
    }

    /**
     * @param mixed $Aboutus_index_anonym_time
     */
    public function setAboutusIndexAnonymTime($Aboutus_index_anonym_time)
    {
        $this->Aboutus_index_anonym_time = $Aboutus_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getAboutusIndexAuthTime()
    {
        return $this->Aboutus_index_auth_time;
    }

    /**
     * @param mixed $Aboutus_index_auth_time
     */
    public function setAboutusIndexAuthTime($Aboutus_index_auth_time)
    {
        $this->Aboutus_index_auth_time = $Aboutus_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsPrivacyPoliticsAnonymVisits()
    {
        return $this->CompanyPolitics_privacyPolitics_anonym_visits;
    }

    /**
     * @param mixed $CompanyPolitics_privacyPolitics_anonym_visits
     */
    public function setCompanyPoliticsPrivacyPoliticsAnonymVisits($CompanyPolitics_privacyPolitics_anonym_visits)
    {
        $this->CompanyPolitics_privacyPolitics_anonym_visits = $CompanyPolitics_privacyPolitics_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsPrivacyPoliticsAuthVisits()
    {
        return $this->CompanyPolitics_privacyPolitics_auth_visits;
    }

    /**
     * @param mixed $CompanyPolitics_privacyPolitics_auth_visits
     */
    public function setCompanyPoliticsPrivacyPoliticsAuthVisits($CompanyPolitics_privacyPolitics_auth_visits)
    {
        $this->CompanyPolitics_privacyPolitics_auth_visits = $CompanyPolitics_privacyPolitics_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsPrivacyPoliticsAnonymTime()
    {
        return $this->CompanyPolitics_privacyPolitics_anonym_time;
    }

    /**
     * @param mixed $CompanyPolitics_privacyPolitics_anonym_time
     */
    public function setCompanyPoliticsPrivacyPoliticsAnonymTime($CompanyPolitics_privacyPolitics_anonym_time)
    {
        $this->CompanyPolitics_privacyPolitics_anonym_time = $CompanyPolitics_privacyPolitics_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsPrivacyPoliticsAuthTime()
    {
        return $this->CompanyPolitics_privacyPolitics_auth_time;
    }

    /**
     * @param mixed $CompanyPolitics_privacyPolitics_auth_time
     */
    public function setCompanyPoliticsPrivacyPoliticsAuthTime($CompanyPolitics_privacyPolitics_auth_time)
    {
        $this->CompanyPolitics_privacyPolitics_auth_time = $CompanyPolitics_privacyPolitics_auth_time;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsTermsAndConditionsAnonymVisits()
    {
        return $this->CompanyPolitics_termsAndConditions_anonym_visits;
    }

    /**
     * @param mixed $CompanyPolitics_termsAndConditions_anonym_visits
     */
    public function setCompanyPoliticsTermsAndConditionsAnonymVisits($CompanyPolitics_termsAndConditions_anonym_visits)
    {
        $this->CompanyPolitics_termsAndConditions_anonym_visits = $CompanyPolitics_termsAndConditions_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsTermsAndConditionsAuthVisits()
    {
        return $this->CompanyPolitics_termsAndConditions_auth_visits;
    }

    /**
     * @param mixed $CompanyPolitics_termsAndConditions_auth_visits
     */
    public function setCompanyPoliticsTermsAndConditionsAuthVisits($CompanyPolitics_termsAndConditions_auth_visits)
    {
        $this->CompanyPolitics_termsAndConditions_auth_visits = $CompanyPolitics_termsAndConditions_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsTermsAndConditionsAnonymTime()
    {
        return $this->CompanyPolitics_termsAndConditions_anonym_time;
    }

    /**
     * @param mixed $CompanyPolitics_termsAndConditions_anonym_time
     */
    public function setCompanyPoliticsTermsAndConditionsAnonymTime($CompanyPolitics_termsAndConditions_anonym_time)
    {
        $this->CompanyPolitics_termsAndConditions_anonym_time = $CompanyPolitics_termsAndConditions_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getCompanyPoliticsTermsAndConditionsAuthTime()
    {
        return $this->CompanyPolitics_termsAndConditions_auth_time;
    }

    /**
     * @param mixed $CompanyPolitics_termsAndConditions_auth_time
     */
    public function setCompanyPoliticsTermsAndConditionsAuthTime($CompanyPolitics_termsAndConditions_auth_time)
    {
        $this->CompanyPolitics_termsAndConditions_auth_time = $CompanyPolitics_termsAndConditions_auth_time;
    }

    /**
     * @return mixed
     */
    public function getDeaUploadFilesAnonymVisits()
    {
        return $this->Dea_uploadFiles_anonym_visits;
    }

    /**
     * @param mixed $Dea_uploadFiles_anonym_visits
     */
    public function setDeaUploadFilesAnonymVisits($Dea_uploadFiles_anonym_visits)
    {
        $this->Dea_uploadFiles_anonym_visits = $Dea_uploadFiles_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getDeaUploadFilesAuthVisits()
    {
        return $this->Dea_uploadFiles_auth_visits;
    }

    /**
     * @param mixed $Dea_uploadFiles_auth_visits
     */
    public function setDeaUploadFilesAuthVisits($Dea_uploadFiles_auth_visits)
    {
        $this->Dea_uploadFiles_auth_visits = $Dea_uploadFiles_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getDeaUploadFilesAnonymTime()
    {
        return $this->Dea_uploadFiles_anonym_time;
    }

    /**
     * @param mixed $Dea_uploadFiles_anonym_time
     */
    public function setDeaUploadFilesAnonymTime($Dea_uploadFiles_anonym_time)
    {
        $this->Dea_uploadFiles_anonym_time = $Dea_uploadFiles_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getDeaUploadFilesAuthTime()
    {
        return $this->Dea_uploadFiles_auth_time;
    }

    /**
     * @param mixed $Dea_uploadFiles_auth_time
     */
    public function setDeaUploadFilesAuthTime($Dea_uploadFiles_auth_time)
    {
        $this->Dea_uploadFiles_auth_time = $Dea_uploadFiles_auth_time;
    }

    /**
     * @return mixed
     */
    public function getDeaIndexAnonymVisits()
    {
        return $this->Dea_index_anonym_visits;
    }

    /**
     * @param mixed $Dea_index_anonym_visits
     */
    public function setDeaIndexAnonymVisits($Dea_index_anonym_visits)
    {
        $this->Dea_index_anonym_visits = $Dea_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getDeaIndexAuthVisits()
    {
        return $this->Dea_index_auth_visits;
    }

    /**
     * @param mixed $Dea_index_auth_visits
     */
    public function setDeaIndexAuthVisits($Dea_index_auth_visits)
    {
        $this->Dea_index_auth_visits = $Dea_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getDeaIndexAnonymTime()
    {
        return $this->Dea_index_anonym_time;
    }

    /**
     * @param mixed $Dea_index_anonym_time
     */
    public function setDeaIndexAnonymTime($Dea_index_anonym_time)
    {
        $this->Dea_index_anonym_time = $Dea_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getDeaIndexAuthTime()
    {
        return $this->Dea_index_auth_time;
    }

    /**
     * @param mixed $Dea_index_auth_time
     */
    public function setDeaIndexAuthTime($Dea_index_auth_time)
    {
        $this->Dea_index_auth_time = $Dea_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getHomeIndexAnonymVisits()
    {
        return $this->Home_index_anonym_visits;
    }

    /**
     * @param mixed $Home_index_anonym_visits
     */
    public function setHomeIndexAnonymVisits($Home_index_anonym_visits)
    {
        $this->Home_index_anonym_visits = $Home_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getHomeIndexAuthVisits()
    {
        return $this->Home_index_auth_visits;
    }

    /**
     * @param mixed $Home_index_auth_visits
     */
    public function setHomeIndexAuthVisits($Home_index_auth_visits)
    {
        $this->Home_index_auth_visits = $Home_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getHomeIndexAnonymTime()
    {
        return $this->Home_index_anonym_time;
    }

    /**
     * @param mixed $Home_index_anonym_time
     */
    public function setHomeIndexAnonymTime($Home_index_anonym_time)
    {
        $this->Home_index_anonym_time = $Home_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getHomeIndexAuthTime()
    {
        return $this->Home_index_auth_time;
    }

    /**
     * @param mixed $Home_index_auth_time
     */
    public function setHomeIndexAuthTime($Home_index_auth_time)
    {
        $this->Home_index_auth_time = $Home_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getLoginIndexAnonymVisits()
    {
        return $this->Login_index_anonym_visits;
    }

    /**
     * @param mixed $Login_index_anonym_visits
     */
    public function setLoginIndexAnonymVisits($Login_index_anonym_visits)
    {
        $this->Login_index_anonym_visits = $Login_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getLoginIndexAuthVisits()
    {
        return $this->Login_index_auth_visits;
    }

    /**
     * @param mixed $Login_index_auth_visits
     */
    public function setLoginIndexAuthVisits($Login_index_auth_visits)
    {
        $this->Login_index_auth_visits = $Login_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getLoginIndexAnonymTime()
    {
        return $this->Login_index_anonym_time;
    }

    /**
     * @param mixed $Login_index_anonym_time
     */
    public function setLoginIndexAnonymTime($Login_index_anonym_time)
    {
        $this->Login_index_anonym_time = $Login_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getLoginIndexAuthTime()
    {
        return $this->Login_index_auth_time;
    }

    /**
     * @param mixed $Login_index_auth_time
     */
    public function setLoginIndexAuthTime($Login_index_auth_time)
    {
        $this->Login_index_auth_time = $Login_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getPricingIndexAnonymVisits()
    {
        return $this->Pricing_index_anonym_visits;
    }

    /**
     * @param mixed $Pricing_index_anonym_visits
     */
    public function setPricingIndexAnonymVisits($Pricing_index_anonym_visits)
    {
        $this->Pricing_index_anonym_visits = $Pricing_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getPricingIndexAuthVisits()
    {
        return $this->Pricing_index_auth_visits;
    }

    /**
     * @param mixed $Pricing_index_auth_visits
     */
    public function setPricingIndexAuthVisits($Pricing_index_auth_visits)
    {
        $this->Pricing_index_auth_visits = $Pricing_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getPricingIndexAnonymTime()
    {
        return $this->Pricing_index_anonym_time;
    }

    /**
     * @param mixed $Pricing_index_anonym_time
     */
    public function setPricingIndexAnonymTime($Pricing_index_anonym_time)
    {
        $this->Pricing_index_anonym_time = $Pricing_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getPricingIndexAuthTime()
    {
        return $this->Pricing_index_auth_time;
    }

    /**
     * @param mixed $Pricing_index_auth_time
     */
    public function setPricingIndexAuthTime($Pricing_index_auth_time)
    {
        $this->Pricing_index_auth_time = $Pricing_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getRegisterIndexAnonymVisits()
    {
        return $this->Register_index_anonym_visits;
    }

    /**
     * @param mixed $Register_index_anonym_visits
     */
    public function setRegisterIndexAnonymVisits($Register_index_anonym_visits)
    {
        $this->Register_index_anonym_visits = $Register_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getRegisterIndexAuthVisits()
    {
        return $this->Register_index_auth_visits;
    }

    /**
     * @param mixed $Register_index_auth_visits
     */
    public function setRegisterIndexAuthVisits($Register_index_auth_visits)
    {
        $this->Register_index_auth_visits = $Register_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getRegisterIndexAnonymTime()
    {
        return $this->Register_index_anonym_time;
    }

    /**
     * @param mixed $Register_index_anonym_time
     */
    public function setRegisterIndexAnonymTime($Register_index_anonym_time)
    {
        $this->Register_index_anonym_time = $Register_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getRegisterIndexAuthTime()
    {
        return $this->Register_index_auth_time;
    }

    /**
     * @param mixed $Register_index_auth_time
     */
    public function setRegisterIndexAuthTime($Register_index_auth_time)
    {
        $this->Register_index_auth_time = $Register_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getServicesIndexAnonymVisits()
    {
        return $this->Services_index_anonym_visits;
    }

    /**
     * @param mixed $Services_index_anonym_visits
     */
    public function setServicesIndexAnonymVisits($Services_index_anonym_visits)
    {
        $this->Services_index_anonym_visits = $Services_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getServicesIndexAuthVisits()
    {
        return $this->Services_index_auth_visits;
    }

    /**
     * @param mixed $Services_index_auth_visits
     */
    public function setServicesIndexAuthVisits($Services_index_auth_visits)
    {
        $this->Services_index_auth_visits = $Services_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getServicesIndexAnonymTime()
    {
        return $this->Services_index_anonym_time;
    }

    /**
     * @param mixed $Services_index_anonym_time
     */
    public function setServicesIndexAnonymTime($Services_index_anonym_time)
    {
        $this->Services_index_anonym_time = $Services_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getServicesIndexAuthTime()
    {
        return $this->Services_index_auth_time;
    }

    /**
     * @param mixed $Services_index_auth_time
     */
    public function setServicesIndexAuthTime($Services_index_auth_time)
    {
        $this->Services_index_auth_time = $Services_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getUserProfileIndexAnonymVisits()
    {
        return $this->UserProfile_index_anonym_visits;
    }

    /**
     * @param mixed $UserProfile_index_anonym_visits
     */
    public function setUserProfileIndexAnonymVisits($UserProfile_index_anonym_visits)
    {
        $this->UserProfile_index_anonym_visits = $UserProfile_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getUserProfileIndexAuthVisits()
    {
        return $this->UserProfile_index_auth_visits;
    }

    /**
     * @param mixed $UserProfile_index_auth_visits
     */
    public function setUserProfileIndexAuthVisits($UserProfile_index_auth_visits)
    {
        $this->UserProfile_index_auth_visits = $UserProfile_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getUserProfileIndexAnonymTime()
    {
        return $this->UserProfile_index_anonym_time;
    }

    /**
     * @param mixed $UserProfile_index_anonym_time
     */
    public function setUserProfileIndexAnonymTime($UserProfile_index_anonym_time)
    {
        $this->UserProfile_index_anonym_time = $UserProfile_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getUserProfileIndexAuthTime()
    {
        return $this->UserProfile_index_auth_time;
    }

    /**
     * @param mixed $UserProfile_index_auth_time
     */
    public function setUserProfileIndexAuthTime($UserProfile_index_auth_time)
    {
        $this->UserProfile_index_auth_time = $UserProfile_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getUserRequestsIndexAnonymVisits()
    {
        return $this->UserRequests_index_anonym_visits;
    }

    /**
     * @param mixed $UserRequests_index_anonym_visits
     */
    public function setUserRequestsIndexAnonymVisits($UserRequests_index_anonym_visits)
    {
        $this->UserRequests_index_anonym_visits = $UserRequests_index_anonym_visits;
    }

    /**
     * @return mixed
     */
    public function getUserRequestsIndexAuthVisits()
    {
        return $this->UserRequests_index_auth_visits;
    }

    /**
     * @param mixed $UserRequests_index_auth_visits
     */
    public function setUserRequestsIndexAuthVisits($UserRequests_index_auth_visits)
    {
        $this->UserRequests_index_auth_visits = $UserRequests_index_auth_visits;
    }

    /**
     * @return mixed
     */
    public function getUserRequestsIndexAnonymTime()
    {
        return $this->UserRequests_index_anonym_time;
    }

    /**
     * @param mixed $UserRequests_index_anonym_time
     */
    public function setUserRequestsIndexAnonymTime($UserRequests_index_anonym_time)
    {
        $this->UserRequests_index_anonym_time = $UserRequests_index_anonym_time;
    }

    /**
     * @return mixed
     */
    public function getUserRequestsIndexAuthTime()
    {
        return $this->UserRequests_index_auth_time;
    }

    /**
     * @param mixed $UserRequests_index_auth_time
     */
    public function setUserRequestsIndexAuthTime($UserRequests_index_auth_time)
    {
        $this->UserRequests_index_auth_time = $UserRequests_index_auth_time;
    }

    /**
     * @return mixed
     */
    public function getMaxUsersOnline()
    {
        return $this->max_users_online;
    }

    /**
     * @param mixed $max_users_online
     */
    public function setMaxUsersOnline($max_users_online)
    {
        $this->max_users_online = $max_users_online;
    }

    /**
     * @return mixed
     */
    public function getCurrentUsersOnline()
    {
        return $this->current_users_online;
    }

    /**
     * @param mixed $current_users_online
     */
    public function setCurrentUsersOnline($current_users_online)
    {
        $this->current_users_online = $current_users_online;
    }

    /**
     * @return mixed
     */
    public function getNumberOfSessions()
    {
        return $this->number_of_sessions;
    }

    /**
     * @param mixed $number_of_sessions
     */
    public function setNumberOfSessions($number_of_sessions)
    {
        $this->number_of_sessions = $number_of_sessions;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}
