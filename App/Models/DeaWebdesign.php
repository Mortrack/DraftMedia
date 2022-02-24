<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * PHP version 5.4
 */
class DeaWebdesign extends \Core\Model
{
    static $DB_TABLE_NAME = 'dea_webdesign';
    static $TABLE_VALUES =
        [
            0 => "id",
            1 => "dea_requests_id",
            2 => "dea_language_id",
            3 => "project_name",
            4 => "website_category",
            5 => "website_views",
            6 => "is_base_colors",
            7 => "base_colors_lvl_attch",
            8 => "website_url",
            9 => "target_audience",
            10 => "what_to_transmit"
        ];

    private $id;
    private $dea_requests_id;
    private $dea_language_id;
    private $project_name;
    private $website_category;
    private $website_views;
    private $is_base_colors;
    private $base_colors_lvl_attch;
    private $website_url;
    private $target_audience;
    private $what_to_transmit;

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
                $resultadoPreparado = $db->prepare("INSERT INTO $thisTable($tv[0],$tv[1],$tv[2],$tv[3],$tv[4],$tv[5],$tv[6],$tv[7],$tv[8],$tv[9],$tv[10]) VALUES (:$tv[0],:$tv[1],:$tv[2],:$tv[3],:$tv[4],:$tv[5],:$tv[6],:$tv[7],:$tv[8],:$tv[9],:$tv[10])");
                $resultadoPreparado->bindParam(':'.$tv[0], $data[0], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[1], $data[1], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[2], $data[2], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[3], $data[3], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[4], $data[4], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[5], $data[5], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[6], $data[6], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[7], $data[7], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[8], $data[8], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[9], $data[9], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[10], $data[10], PDO::PARAM_STR);
                $resultadoPreparado->execute();
            } catch(\PDOException $e)
            {
                throw new \Exception(new \Core\Dump($e));
            }
        } else {
            //update
            try {
                $existingObject = DeaWebdesign::find($data[0])[0];
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
    public function getDeaRequestsId()
    {
        return $this->dea_requests_id;
    }

    /**
     * @param mixed $dea_requests_id
     */
    public function setDeaRequestsId($dea_requests_id)
    {
        $this->dea_requests_id = $dea_requests_id;
    }

    /**
     * @return mixed
     */
    public function getDeaLanguageId()
    {
        return $this->dea_language_id;
    }

    /**
     * @param mixed $dea_language_id
     */
    public function setDeaLanguageId($dea_language_id)
    {
        $this->dea_language_id = $dea_language_id;
    }

    /**
     * @return mixed
     */
    public function getProjectName()
    {
        return $this->project_name;
    }

    /**
     * @param mixed $project_name
     */
    public function setProjectName($project_name)
    {
        $this->project_name = $project_name;
    }

    /**
     * @return mixed
     */
    public function getWebsiteCategory()
    {
        return $this->website_category;
    }

    /**
     * @param mixed $website_category
     */
    public function setWebsiteCategory($website_category)
    {
        $this->website_category = $website_category;
    }

    /**
     * @return mixed
     */
    public function getWebsiteViews()
    {
        return $this->website_views;
    }

    /**
     * @param mixed $website_views
     */
    public function setWebsiteViews($website_views)
    {
        $this->website_views = $website_views;
    }

    /**
     * @return mixed
     */
    public function getisBaseColors()
    {
        return $this->is_base_colors;
    }

    /**
     * @param mixed $is_base_colors
     */
    public function setIsBaseColors($is_base_colors)
    {
        $this->is_base_colors = $is_base_colors;
    }

    /**
     * @return mixed
     */
    public function getBaseColorsLvlAttch()
    {
        return $this->base_colors_lvl_attch;
    }

    /**
     * @param mixed $base_colors_lvl_attch
     */
    public function setBaseColorsLvlAttch($base_colors_lvl_attch)
    {
        $this->base_colors_lvl_attch = $base_colors_lvl_attch;
    }

    /**
     * @return mixed
     */
    public function getWebsiteUrl()
    {
        return $this->website_url;
    }

    /**
     * @param mixed $website_url
     */
    public function setWebsiteUrl($website_url)
    {
        $this->website_url = $website_url;
    }

    /**
     * @return mixed
     */
    public function getTargetAudience()
    {
        return $this->target_audience;
    }

    /**
     * @param mixed $target_audience
     */
    public function setTargetAudience($target_audience)
    {
        $this->target_audience = $target_audience;
    }

    /**
     * @return mixed
     */
    public function getWhatToTransmit()
    {
        return $this->what_to_transmit;
    }

    /**
     * @param mixed $what_to_transmit
     */
    public function setWhatToTransmit($what_to_transmit)
    {
        $this->what_to_transmit = $what_to_transmit;
    }
}
