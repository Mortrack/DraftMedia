<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * PHP version 5.4
 */
class Users extends \Core\Model
{
    static $DB_TABLE_NAME = 'users';
    static $TABLE_VALUES =
        [
            0 => "id",
            1 => "email",
            2 => "first_name",
            3 => "last_name",
            4 => "role",
            5 => "password",
            6 => "privacy_politics",
            7 => "activation_code",
            8 => "status",
            9 => "created_by",
            10 => "modified_by",
            11 => "last_activity_at",
            12 => "connected_at",
            13 => "disconnected_at",
            14 => "created_at",
            15 => "modified_at",
            16 => "deleted_at"
        ];

    private $id;
    private $email;
    private $first_name;
    private $last_name;
    private $role;
    private $password;
    private $privacy_politics;
    private $activation_code;
    private $status;
    private $created_by;
    private $modified_by;
    private $last_activity_at;
    private $connected_at;
    private $disconnected_at;
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
                $resultadoPreparado = $db->prepare("INSERT INTO $thisTable($tv[0],$tv[1],$tv[2],$tv[3],$tv[4],$tv[5],$tv[6],$tv[7],$tv[8],$tv[9],$tv[10],$tv[11],$tv[12],$tv[13],$tv[14],$tv[15],$tv[16]) VALUES (:$tv[0],:$tv[1],:$tv[2],:$tv[3],:$tv[4],:$tv[5],:$tv[6],:$tv[7],:$tv[8],:$tv[9],:$tv[10],:$tv[11],:$tv[12],:$tv[13],:$tv[14],:$tv[15],:$tv[16])");
                $resultadoPreparado->bindParam(':'.$tv[0], $data[0], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[1], $data[1], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[2], $data[2], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[3], $data[3], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[4], $data[4], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[5], $data[5], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[6], $data[6], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[7], $data[7], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[8], $data[8], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[9], $data[9], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[10], $data[10], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[11], $data[11]);
                $resultadoPreparado->bindParam(':'.$tv[12], $data[12]);
                $resultadoPreparado->bindParam(':'.$tv[13], $data[13]);
                $resultadoPreparado->bindParam(':'.$tv[14], $data[14]);
                $resultadoPreparado->bindParam(':'.$tv[15], $data[15]);
                $resultadoPreparado->bindParam(':'.$tv[16], $data[16]);
                $resultadoPreparado->execute();
            } catch(\PDOException $e)
            {
                throw new \Exception(new \Core\Dump($e));
            }
        } else {
            //update
            try {
                $existingObject = Users::find($data[0])[0];
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param mixed $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getPrivacyPolitics()
    {
        return $this->privacy_politics;
    }

    /**
     * @param mixed $privacy_politics
     */
    public function setPrivacyPolitics($privacy_politics)
    {
        $this->privacy_politics = $privacy_politics;
    }

    /**
     * @return mixed
     */
    public function getActivationCode()
    {
        return $this->activation_code;
    }

    /**
     * @param mixed $activation_code
     */
    public function setActivationCode($activation_code)
    {
        $this->activation_code = $activation_code;
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
    public function getLastActivityAt()
    {
        return $this->last_activity_at;
    }

    /**
     * @param mixed $last_activity_at
     */
    public function setLastActivityAt($last_activity_at)
    {
        $this->last_activity_at = $last_activity_at;
    }

    /**
     * @return mixed
     */
    public function getConnectedAt()
    {
        return $this->connected_at;
    }

    /**
     * @param mixed $connected_at
     */
    public function setConnectedAt($connected_at)
    {
        $this->connected_at = $connected_at;
    }

    /**
     * @return mixed
     */
    public function getDisconnectedAt()
    {
        return $this->disconnected_at;
    }

    /**
     * @param mixed $disconnected_at
     */
    public function setDisconnectedAt($disconnected_at)
    {
        $this->disconnected_at = $disconnected_at;
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
