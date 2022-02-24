<?php

namespace App\Models;

use PDO;

/**
 * IMPORTANT: In order for this class to work, at least an existing row value must exist on the database
 *            on the table "hack_attempts".
 */
class HackAttempts extends \Core\Model
{
    static $DB_TABLE_NAME = 'hack_attempts';
    static $TABLE_VALUES =
        [
            0 => "id",
            1 => "aboutus",
            2 => "companypolitics",
            3 => "controller",
            4 => "dea",
            5 => "home",
            6 => "login",
            7 => "paypal",
            8 => "portfolio",
            9 => "pricing",
            10 => "register",
            11 => "services",
            12 => "user_profile",
            13 => "user_requests",
            14 => "admin_email",
            15 => "admin_login",
            16 => "admin_summary",
            17 => "method",
            18 => "user_real_ip_address",
            19 => "country",
            20 => "region",
            21 => "city",
            22 => "zipcode",
            23 => "organization",
            24 => "latitude",
            25 => "longitude",
            26 => "created_by",
            27 => "created_at"
        ];

    private $id;
    private $aboutus;
    private $companypolitics;
    private $controller;
    private $dea;
    private $home;
    private $login;
    private $paypal;
    private $portfolio;
    private $pricing;
    private $register;
    private $services;
    private $user_profile;
    private $user_requests;
    private $admin_email;
    private $admin_login;
    private $admin_summary;
    private $method;
    private $user_real_ip_address;
    private $country;
    private $region;
    private $city;
    private $zipcode;
    private $organization;
    private $latitude;
    private $longitude;
    private $created_by;
    private $created_at;

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
     * DATE October 26, 2018
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
     * DATE October 26, 2018
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
     * DATE October 26, 2018
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
     * DATE October 26, 2018
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
                $resultadoPreparado = $db->prepare("INSERT INTO $thisTable($tv[0],$tv[1],$tv[2],$tv[3],$tv[4],$tv[5],$tv[6],$tv[7],$tv[8],$tv[9],$tv[10],$tv[11],$tv[12],$tv[13],$tv[14],$tv[15],$tv[16],$tv[17],$tv[18],$tv[19],$tv[20],$tv[21],$tv[22],$tv[23],$tv[24],$tv[25],$tv[26],$tv[27]) VALUES (:$tv[0],:$tv[1],:$tv[2],:$tv[3],:$tv[4],:$tv[5],:$tv[6],:$tv[7],:$tv[8],:$tv[9],:$tv[10],:$tv[11],:$tv[12],:$tv[13],:$tv[14],:$tv[15],:$tv[16],:$tv[17],:$tv[18],:$tv[19],:$tv[20],:$tv[21],:$tv[22],:$tv[23],:$tv[24],:$tv[25],:$tv[26],:$tv[27])");
                $resultadoPreparado->bindParam(':'.$tv[0], $data[0], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[1], $data[1], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[2], $data[2], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[3], $data[3], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[4], $data[4], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[5], $data[5], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[6], $data[6], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[7], $data[7], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[8], $data[8], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[9], $data[9], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[10], $data[10], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[11], $data[11], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[12], $data[12], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[13], $data[13], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[14], $data[14], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[15], $data[15], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[16], $data[16], PDO::PARAM_INT);
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
                $resultadoPreparado->bindParam(':'.$tv[27], $data[27]);
                $resultadoPreparado->execute();
            } catch(\PDOException $e)
            {
                throw new \Exception(new \Core\Dump($e));
            }
        } else {
            //update
            try {
                $existingObject = HackAttempts::find($data[0])[0];
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
    public function getAboutus()
    {
        return $this->aboutus;
    }

    /**
     * @param mixed $aboutus
     */
    public function setAboutus($aboutus)
    {
        $this->aboutus = $aboutus;
    }

    /**
     * @return mixed
     */
    public function getCompanypolitics()
    {
        return $this->companypolitics;
    }

    /**
     * @param mixed $companypolitics
     */
    public function setCompanypolitics($companypolitics)
    {
        $this->companypolitics = $companypolitics;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller)
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getDea()
    {
        return $this->dea;
    }

    /**
     * @param mixed $dea
     */
    public function setDea($dea)
    {
        $this->dea = $dea;
    }

    /**
     * @return mixed
     */
    public function getHome()
    {
        return $this->home;
    }

    /**
     * @param mixed $home
     */
    public function setHome($home)
    {
        $this->home = $home;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getPaypal()
    {
        return $this->paypal;
    }

    /**
     * @param mixed $paypal
     */
    public function setPaypal($paypal)
    {
        $this->paypal = $paypal;
    }

    /**
     * @return mixed
     */
    public function getPortfolio()
    {
        return $this->portfolio;
    }

    /**
     * @param mixed $portfolio
     */
    public function setPortfolio($portfolio)
    {
        $this->portfolio = $portfolio;
    }

    /**
     * @return mixed
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * @param mixed $pricing
     */
    public function setPricing($pricing)
    {
        $this->pricing = $pricing;
    }

    /**
     * @return mixed
     */
    public function getRegister()
    {
        return $this->register;
    }

    /**
     * @param mixed $register
     */
    public function setRegister($register)
    {
        $this->register = $register;
    }

    /**
     * @return mixed
     */
    public function getServices()
    {
        return $this->services;
    }

    /**
     * @param mixed $services
     */
    public function setServices($services)
    {
        $this->services = $services;
    }

    /**
     * @return mixed
     */
    public function getUserProfile()
    {
        return $this->user_profile;
    }

    /**
     * @param mixed $user_profile
     */
    public function setUserProfile($user_profile)
    {
        $this->user_profile = $user_profile;
    }

    /**
     * @return mixed
     */
    public function getUserRequests()
    {
        return $this->user_requests;
    }

    /**
     * @param mixed $user_requests
     */
    public function setUserRequests($user_requests)
    {
        $this->user_requests = $user_requests;
    }

    /**
     * @return mixed
     */
    public function getAdminEmail()
    {
        return $this->admin_email;
    }

    /**
     * @param mixed $admin_email
     */
    public function setAdminEmail($admin_email)
    {
        $this->admin_email = $admin_email;
    }

    /**
     * @return mixed
     */
    public function getAdminLogin()
    {
        return $this->admin_login;
    }

    /**
     * @param mixed $admin_login
     */
    public function setAdminLogin($admin_login)
    {
        $this->admin_login = $admin_login;
    }

    /**
     * @return mixed
     */
    public function getAdminSummary()
    {
        return $this->admin_summary;
    }

    /**
     * @param mixed $admin_summary
     */
    public function setAdminSummary($admin_summary)
    {
        $this->admin_summary = $admin_summary;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return mixed
     */
    public function getUserRealIpAddress()
    {
        return $this->user_real_ip_address;
    }

    /**
     * @param mixed $user_real_ip_address
     */
    public function setUserRealIpAddress($user_real_ip_address)
    {
        $this->user_real_ip_address = $user_real_ip_address;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param mixed $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * @param mixed $zipcode
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    /**
     * @return mixed
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * @param mixed $organization
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * @param mixed $created_by
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}
