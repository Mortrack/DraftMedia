<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * PHP version 5.4
 */
class AccountRegistery extends \Core\Model
{
    static $DB_TABLE_NAME = 'account_registery';
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
            10 => "created_at"
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
                $resultadoPreparado = $db->prepare("INSERT INTO $thisTable($tv[0],$tv[1],$tv[2],$tv[3],$tv[4],$tv[5],$tv[6],$tv[7],$tv[8],$tv[9],$tv[10]) VALUES (:$tv[0],:$tv[1],:$tv[2],:$tv[3],:$tv[4],:$tv[5],:$tv[6],:$tv[7],:$tv[8],:$tv[9],:$tv[10])");
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
                $resultadoPreparado->bindParam(':'.$tv[10], $data[10]);
                $resultadoPreparado->execute();
                } catch(\PDOException $e)
                {
                    throw new \Exception(new \Core\Dump($e));
                }
        } else {
            //update
            try {
                    $existingObject = AccountRegistery::find($data[0])[0];
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
    /*
    public static function setPayment($api_context)
    {
        try {
            $thisTable = static::$DB_TABLE_NAME;
            $db = static::getDB();
            $resultadoPreparado = $db->prepare("INSERT INTO $thisTable(api_context) VALUES (:api_context)");
            $resultadoPreparado->bindParam(':api_context', $api_context, PDO::PARAM_STR);
            $resultadoPreparado->execute();
        }catch(PDOException $e)
        {//"PDOException $e" nos emitirá una excepcion si hay algun error.
        }
    }

    public static function updatePaymentById($id, $api_context)
    {
        try {
            $thisTable = static::$DB_TABLE_NAME;
            $db = static::getDB();
            $resultadoPreparado = $db->prepare("UPDATE $thisTable SET api_context=:api_context WHERE id=:id");
            $resultadoPreparado->bindParam(':api_context', $api_context, PDO::PARAM_STR);
            $resultadoPreparado->bindParam(':id', $id, PDO::PARAM_STR);
            $resultadoPreparado->execute();
        }catch(PDOException $e)
        {//"PDOException $e" nos emitirá una excepcion si hay algun error.
        }
    }
    */

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
