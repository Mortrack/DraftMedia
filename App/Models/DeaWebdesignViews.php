<?php

namespace App\Models;

use PDO;

/**
 * Post model
 *
 * PHP version 5.4
 */
class DeaWebdesignViews extends \Core\Model
{
    static $DB_TABLE_NAME = 'dea_webdesign_views';
    static $TABLE_VALUES =
        [
            0 => "id",
            1 => "dea_webdesign_id",
            2 => "type_of_website",
            3 => "sections_quantity",
            4 => "is_user_art_concept",
            5 => "user_art_concept_dir",
            6 => "is_ext_art_concept",
            7 => "ext_art_concept_url",
            8 => "ext_art_concept_exp",
            9 => "is_user_ani_concept",
            10 => "user_ani_concept_dir",
            11 => "is_ext_ani_concept",
            12 => "ext_ani_concept_url",
            13 => "ext_ani_concept_exp",
            14 => "is_other_concept",
            15 => "other_concept_url",
            16 => "other_concept_exp",
            17 => "is_logic_diagram",
            18 => "logic_diagram_dir",
            19 => "logic_diagram_exp",
            20 => "section1_content",
            21 => "section2_content",
            22 => "section3_content",
            23 => "section4_content",
            24 => "section5_content"
        ];

    private $id;
    private $dea_webdesign_id;
    private $type_of_website;
    private $sections_quantity;
    private $is_user_art_concept;
    private $user_art_concept_dir;
    private $is_ext_art_concept;
    private $ext_art_concept_url;
    private $ext_art_concept_exp;
    private $is_user_ani_concept;
    private $user_ani_concept_dir;
    private $is_ext_ani_concept;
    private $ext_ani_concept_url;
    private $ext_ani_concept_exp;
    private $is_other_concept;
    private $other_concept_url;
    private $other_concept_exp;
    private $is_logic_diagram;
    private $logic_diagram_dir;
    private $logic_diagram_exp;
    private $section1_content;
    private $section2_content;
    private $section3_content;
    private $section4_content;
    private $section5_content;


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
     * DATE November 05, 2018
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
     * DATE November 05, 2018
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
     * DATE November 05, 2018
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
     * DATE November 05, 2018
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
                $resultadoPreparado = $db->prepare("INSERT INTO $thisTable($tv[0],$tv[1],$tv[2],$tv[3],$tv[4],$tv[5],$tv[6],$tv[7],$tv[8],$tv[9],$tv[10],$tv[11],$tv[12],$tv[13],$tv[14],$tv[15],$tv[16],$tv[17],$tv[18],$tv[19],$tv[20],$tv[21],$tv[22],$tv[23],$tv[24]) VALUES (:$tv[0],:$tv[1],:$tv[2],:$tv[3],:$tv[4],:$tv[5],:$tv[6],:$tv[7],:$tv[8],:$tv[9],:$tv[10],:$tv[11],:$tv[12],:$tv[13],:$tv[14],:$tv[15],:$tv[16],:$tv[17],:$tv[18],:$tv[19],:$tv[20],:$tv[21],:$tv[22],:$tv[23],:$tv[24])");
                $resultadoPreparado->bindParam(':'.$tv[0], $data[0], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[1], $data[1], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[2], $data[2], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[3], $data[3], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[4], $data[4], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[5], $data[5], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[6], $data[6], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[7], $data[7], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[8], $data[8], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[9], $data[9], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[10], $data[10], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[11], $data[11], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[12], $data[12], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[13], $data[13], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[14], $data[14], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[15], $data[15], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[16], $data[16], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[17], $data[17], PDO::PARAM_INT);
                $resultadoPreparado->bindParam(':'.$tv[18], $data[18], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[19], $data[19], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[20], $data[20], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[21], $data[21], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[22], $data[22], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[23], $data[23], PDO::PARAM_STR);
                $resultadoPreparado->bindParam(':'.$tv[24], $data[24], PDO::PARAM_STR);
                $resultadoPreparado->execute();
            } catch(\PDOException $e)
            {
                throw new \Exception(new \Core\Dump($e));
            }
        } else {
            //update
            try {
                $existingObject = DeaWebdesignViews::find($data[0])[0];
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
    public function getDeaWebdesignId()
    {
        return $this->dea_webdesign_id;
    }

    /**
     * @param mixed $dea_webdesign_id
     */
    public function setDeaWebdesignId($dea_webdesign_id)
    {
        $this->dea_webdesign_id = $dea_webdesign_id;
    }

    /**
     * @return mixed
     */
    public function getTypeOfWebsite()
    {
        return $this->type_of_website;
    }

    /**
     * @param mixed $type_of_website
     */
    public function setTypeOfWebsite($type_of_website)
    {
        $this->type_of_website = $type_of_website;
    }

    /**
     * @return mixed
     */
    public function getSectionsQuantity()
    {
        return $this->sections_quantity;
    }

    /**
     * @param mixed $sections_quantity
     */
    public function setSectionsQuantity($sections_quantity)
    {
        $this->sections_quantity = $sections_quantity;
    }

    /**
     * @return mixed
     */
    public function getisUserArtConcept()
    {
        return $this->is_user_art_concept;
    }

    /**
     * @param mixed $is_user_art_concept
     */
    public function setIsUserArtConcept($is_user_art_concept)
    {
        $this->is_user_art_concept = $is_user_art_concept;
    }

    /**
     * @return mixed
     */
    public function getUserArtConceptDir()
    {
        return $this->user_art_concept_dir;
    }

    /**
     * @param mixed $user_art_concept_dir
     */
    public function setUserArtConceptDir($user_art_concept_dir)
    {
        $this->user_art_concept_dir = $user_art_concept_dir;
    }

    /**
     * @return mixed
     */
    public function getisExtArtConcept()
    {
        return $this->is_ext_art_concept;
    }

    /**
     * @param mixed $is_ext_art_concept
     */
    public function setIsExtArtConcept($is_ext_art_concept)
    {
        $this->is_ext_art_concept = $is_ext_art_concept;
    }

    /**
     * @return mixed
     */
    public function getExtArtConceptUrl()
    {
        return $this->ext_art_concept_url;
    }

    /**
     * @param mixed $ext_art_concept_url
     */
    public function setExtArtConceptUrl($ext_art_concept_url)
    {
        $this->ext_art_concept_url = $ext_art_concept_url;
    }

    /**
     * @return mixed
     */
    public function getExtArtConceptExp()
    {
        return $this->ext_art_concept_exp;
    }

    /**
     * @param mixed $ext_art_concept_exp
     */
    public function setExtArtConceptExp($ext_art_concept_exp)
    {
        $this->ext_art_concept_exp = $ext_art_concept_exp;
    }

    /**
     * @return mixed
     */
    public function getisUserAniConcept()
    {
        return $this->is_user_ani_concept;
    }

    /**
     * @param mixed $is_user_ani_concept
     */
    public function setIsUserAniConcept($is_user_ani_concept)
    {
        $this->is_user_ani_concept = $is_user_ani_concept;
    }

    /**
     * @return mixed
     */
    public function getUserAniConceptDir()
    {
        return $this->user_ani_concept_dir;
    }

    /**
     * @param mixed $user_ani_concept_dir
     */
    public function setUserAniConceptDir($user_ani_concept_dir)
    {
        $this->user_ani_concept_dir = $user_ani_concept_dir;
    }

    /**
     * @return mixed
     */
    public function getisExtAniConcept()
    {
        return $this->is_ext_ani_concept;
    }

    /**
     * @param mixed $is_ext_ani_concept
     */
    public function setIsExtAniConcept($is_ext_ani_concept)
    {
        $this->is_ext_ani_concept = $is_ext_ani_concept;
    }

    /**
     * @return mixed
     */
    public function getExtAniConceptUrl()
    {
        return $this->ext_ani_concept_url;
    }

    /**
     * @param mixed $ext_ani_concept_url
     */
    public function setExtAniConceptUrl($ext_ani_concept_url)
    {
        $this->ext_ani_concept_url = $ext_ani_concept_url;
    }

    /**
     * @return mixed
     */
    public function getExtAniConceptExp()
    {
        return $this->ext_ani_concept_exp;
    }

    /**
     * @param mixed $ext_ani_concept_exp
     */
    public function setExtAniConceptExp($ext_ani_concept_exp)
    {
        $this->ext_ani_concept_exp = $ext_ani_concept_exp;
    }

    /**
     * @return mixed
     */
    public function getisOtherConcept()
    {
        return $this->is_other_concept;
    }

    /**
     * @param mixed $is_other_concept
     */
    public function setIsOtherConcept($is_other_concept)
    {
        $this->is_other_concept = $is_other_concept;
    }

    /**
     * @return mixed
     */
    public function getOtherConceptUrl()
    {
        return $this->other_concept_url;
    }

    /**
     * @param mixed $other_concept_url
     */
    public function setOtherConceptUrl($other_concept_url)
    {
        $this->other_concept_url = $other_concept_url;
    }

    /**
     * @return mixed
     */
    public function getOtherConceptExp()
    {
        return $this->other_concept_exp;
    }

    /**
     * @param mixed $other_concept_exp
     */
    public function setOtherConceptExp($other_concept_exp)
    {
        $this->other_concept_exp = $other_concept_exp;
    }

    /**
     * @return mixed
     */
    public function getisLogicDiagram()
    {
        return $this->is_logic_diagram;
    }

    /**
     * @param mixed $is_logic_diagram
     */
    public function setIsLogicDiagram($is_logic_diagram)
    {
        $this->is_logic_diagram = $is_logic_diagram;
    }

    /**
     * @return mixed
     */
    public function getLogicDiagramDir()
    {
        return $this->logic_diagram_dir;
    }

    /**
     * @param mixed $logic_diagram_dir
     */
    public function setLogicDiagramDir($logic_diagram_dir)
    {
        $this->logic_diagram_dir = $logic_diagram_dir;
    }

    /**
     * @return mixed
     */
    public function getLogicDiagramExp()
    {
        return $this->logic_diagram_exp;
    }

    /**
     * @param mixed $logic_diagram_exp
     */
    public function setLogicDiagramExp($logic_diagram_exp)
    {
        $this->logic_diagram_exp = $logic_diagram_exp;
    }

    /**
     * @return mixed
     */
    public function getSection1Content()
    {
        return $this->section1_content;
    }

    /**
     * @param mixed $section1_content
     */
    public function setSection1Content($section1_content)
    {
        $this->section1_content = $section1_content;
    }

    /**
     * @return mixed
     */
    public function getSection2Content()
    {
        return $this->section2_content;
    }

    /**
     * @param mixed $section2_content
     */
    public function setSection2Content($section2_content)
    {
        $this->section2_content = $section2_content;
    }

    /**
     * @return mixed
     */
    public function getSection3Content()
    {
        return $this->section3_content;
    }

    /**
     * @param mixed $section3_content
     */
    public function setSection3Content($section3_content)
    {
        $this->section3_content = $section3_content;
    }

    /**
     * @return mixed
     */
    public function getSection4Content()
    {
        return $this->section4_content;
    }

    /**
     * @param mixed $section4_content
     */
    public function setSection4Content($section4_content)
    {
        $this->section4_content = $section4_content;
    }

    /**
     * @return mixed
     */
    public function getSection5Content()
    {
        return $this->section5_content;
    }

    /**
     * @param mixed $section5_content
     */
    public function setSection5Content($section5_content)
    {
        $this->section5_content = $section5_content;
    }
}
