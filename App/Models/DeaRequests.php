<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * PHP version 5.4
 */
class DeaRequests extends \Core\Model
{
    static $DB_TABLE_NAME = 'dea_requests';
    static $TABLE_VALUES =
        [
            0 => "id",
            1 => "orders_id",
            2 => "products_id",
            3 => "first_name",
            4 => "last_name",
            5 => "phone",
            6 => "sex",
            7 => "company_name",
            8 => "country",
            9 => "know_about_us",
            10 => "workfield",
            11 => "terms_and_conditions",
            12 => "service_required",
            13 => "package_required",
            14 => "service_status",
            15 => "status",
            16 => "created_by",
            17 => "modified_by",
            18 => "opening_paid_at",
            19 => "service_active_up_to",
            20 => "created_at",
            21 => "modified_at",
            22 => "deleted_at"
        ];

    private $id;
    private $orders_id;
    private $products_id;
    private $first_name;
    private $last_name;
    private $phone;
    private $sex;
    private $company_name;
    private $country;
    private $know_about_us;
    private $workfield;
    private $terms_and_conditions;
    private $service_required;
    private $package_required;
    private $service_status;
    private $status;
    private $created_by;
    private $modified_by;
    private $opening_paid_at;
    private $service_active_up_to;
    private $created_at;
    private $modified_at;
    private $deleted_at;

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
     * DATE November 02, 2018
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
     * DATE November 02, 2018
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
     * DATE November 02, 2018
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
     * DATE November 02, 2018
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
                $resultadoPreparado = $db->prepare("INSERT INTO $thisTable($tv[0],$tv[1],$tv[2],$tv[3],$tv[4],$tv[5],$tv[6],$tv[7],$tv[8],$tv[9],$tv[10],$tv[11],$tv[12],$tv[13],$tv[14],$tv[15],$tv[16],$tv[17],$tv[18],$tv[19],$tv[20],$tv[21],$tv[22]) VALUES (:$tv[0],:$tv[1],:$tv[2],:$tv[3],:$tv[4],:$tv[5],:$tv[6],:$tv[7],:$tv[8],:$tv[9],:$tv[10],:$tv[11],:$tv[12],:$tv[13],:$tv[14],:$tv[15],:$tv[16],:$tv[17],:$tv[18],:$tv[19],:$tv[20],:$tv[21],:$tv[22])");
                $resultadoPreparado->bindParam(':'.$tv[0], $data[0], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[1], $data[1], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[2], $data[2], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[3], $data[3], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[4], $data[4], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[5], $data[5], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[6], $data[6], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[7], $data[7], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[8], $data[8], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[9], $data[9], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[10], $data[10], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[11], $data[11], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[12], $data[12], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[13], $data[13], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[14], $data[14], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[15], $data[15], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[16], $data[16], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[17], $data[17], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[18], $data[18]);
                $resultadoPreparado->bindParam(':'.$tv[19], $data[19]);
                $resultadoPreparado->bindParam(':'.$tv[20], $data[20]);
                $resultadoPreparado->bindParam(':'.$tv[21], $data[21]);
                $resultadoPreparado->bindParam(':'.$tv[22], $data[22]);
                $resultadoPreparado->execute();
            } catch(\PDOException $e)
            {
                throw new \Exception(new \Core\Dump($e));
            }
        } else {
            //update
            try {
                $existingObject = DeaRequests::find($data[0])[0];
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
    public function getOrdersId()
    {
        return $this->orders_id;
    }

    /**
     * @param mixed $orders_id
     */
    public function setOrdersId($orders_id)
    {
        $this->orders_id = $orders_id;
    }

    /**
     * @return mixed
     */
    public function getProductsId()
    {
        return $this->products_id;
    }

    /**
     * @param mixed $products_id
     */
    public function setProductsId($products_id)
    {
        $this->products_id = $products_id;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name)
    {
        $this->last_name = $last_name;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @param mixed $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
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
    public function getKnowAboutUs()
    {
        return $this->know_about_us;
    }

    /**
     * @param mixed $know_about_us
     */
    public function setKnowAboutUs($know_about_us)
    {
        $this->know_about_us = $know_about_us;
    }

    /**
     * @return mixed
     */
    public function getWorkfield()
    {
        return $this->workfield;
    }

    /**
     * @param mixed $workfield
     */
    public function setWorkfield($workfield)
    {
        $this->workfield = $workfield;
    }

    /**
     * @return mixed
     */
    public function getTermsAndConditions()
    {
        return $this->terms_and_conditions;
    }

    /**
     * @param mixed $terms_and_conditions
     */
    public function setTermsAndConditions($terms_and_conditions)
    {
        $this->terms_and_conditions = $terms_and_conditions;
    }

    /**
     * @return mixed
     */
    public function getServiceRequired()
    {
        return $this->service_required;
    }

    /**
     * @param mixed $service_required
     */
    public function setServiceRequired($service_required)
    {
        $this->service_required = $service_required;
    }

    /**
     * @return mixed
     */
    public function getPackageRequired()
    {
        return $this->package_required;
    }

    /**
     * @param mixed $package_required
     */
    public function setPackageRequired($package_required)
    {
        $this->package_required = $package_required;
    }

    /**
     * @return mixed
     */
    public function getServiceStatus()
    {
        return $this->service_status;
    }

    /**
     * @param mixed $service_status
     */
    public function setServiceStatus($service_status)
    {
        $this->service_status = $service_status;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * @param mixed $modified_by
     */
    public function setModifiedBy($modified_by)
    {
        $this->modified_by = $modified_by;
    }

    /**
     * @return mixed
     */
    public function getOpeningPaidAt()
    {
        return $this->opening_paid_at;
    }

    /**
     * @param mixed $opening_paid_at
     */
    public function setOpeningPaidAt($opening_paid_at)
    {
        $this->opening_paid_at = $opening_paid_at;
    }

    /**
     * @return mixed
     */
    public function getServiceActiveUpTo()
    {
        return $this->service_active_up_to;
    }

    /**
     * @param mixed $service_active_up_to
     */
    public function setServiceActiveUpTo($service_active_up_to)
    {
        $this->service_active_up_to = $service_active_up_to;
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

    /**
     * @return mixed
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * @param mixed $modified_at
     */
    public function setModifiedAt($modified_at)
    {
        $this->modified_at = $modified_at;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }
}
