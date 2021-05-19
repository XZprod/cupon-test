<?php

namespace App\models;


use App\HtmlHelper;
use App\ServiceLocator;
use App\validators\AbstractValidator;
use PDO;

abstract class AbstractModel
{
    protected $errors = null;
    protected $isNew = true;

    protected static $where;
    protected static $orderBy;
    protected static $tableRows;

    abstract public static function rules();

    abstract public static function getTableName();

    abstract public static function getLabels();

    public function __construct($fields = [])
    {
        foreach ($fields as $field => $value) {
            $this->{$field} = HtmlHelper::escape($value);
        }
    }

    public function load($data)
    {
        foreach ($data as $k => $e) {
            $this->{$k} = HtmlHelper::escape($e);
        }
    }

    public function save()
    {
        if (!$this->isNew) {
//            $this->update();
        } else {
            return $this->add();
        }
    }


    protected function add()
    {
        /** @var PDO $connect */
        $connect = ServiceLocator::getInstance()->getService('db')->getConnect();

        $tableFields = static::getTableRows();

        $fields = [];
        $bindValues = [];

        foreach ($tableFields as $field) {
            if ($this->{$field}) {
                $fields[] = $field;
                $bindValues[":$field"] = $this->{$field};
            }
        }
//        $bindValues = implode(', ', $bindValues);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', array_keys($bindValues)) . ') ';
        //вынести в db
        $sth = $connect->prepare($sql);
        foreach ($fields as $field) {
            $sth->bindParam($field, $bindValues[":$field"]);
        }
        $result = $sth->execute();
        if ($result) return true;
        return false;
    }


    public function find($conditionParams = [])
    {

    }


    //fixme поправить дыру
    public static function findAll($conditionParams = [])
    {
        $table = static::getTableName();
        $orderBy = self::$orderBy ?? '';
        $query = "select * from {$table}";
        if ($orderBy) {
            $query.= ' order by ' . $orderBy . ' desc';
        }
        $results = self::fetch($query);
        $models = [];
        foreach ($results as $result) {
            $model = new static($result);
            $model->isNew = false;
            $models[] = $model;
        }

        return $models;
    }

    public function validate()
    {
        foreach ($this->rules() as $attribute => $validatorName) {
            $ruleClass = 'App\validators\\' . ucfirst($validatorName) . 'Validator';
            if (!class_exists($ruleClass)) {
                throw new \Exception("Не найден валидатор $ruleClass");
            }
            /** @var AbstractValidator $validator */
            $validator = new $ruleClass($this->{$attribute});
            if (!$validator->validate()) {
                $this->addError($attribute, $validator->getErrorMessage());
            }
        }
        if (!$this->getErrors()) return true;
    }

    public function getErrors()
    {
        return $this->errors ?? null;
    }

    public function addError($attribute, $msg)
    {
        $this->errors[$attribute] = $msg;
    }

    public function clearErrors()
    {
        $this->errors = null;
    }

    public static function getTableRows()
    {
        if (!self::$tableRows) {
            $tableName = static::getTableName();
            $rowsQuery = "describe $tableName;";
            $describe = self::fetch($rowsQuery);
            //fixme сделать покрасивей
            foreach ($describe as $row) {
                self::$tableRows[] = $row['Field'];
            }
        }
        return self::$tableRows;
    }

    protected static function fetch($query)
    {
        return ServiceLocator::getInstance()->getService('db')->fetch($query);
    }

    protected static function query($query)
    {
        return ServiceLocator::getInstance()->getService('db')->exec($query);
    }


    public function __get($name)
    {
        if (in_array($name, self::getTableRows())) {
            $this->{$name} = '';
        }
        return $this->{$name} = '';
    }

    public static function orderBy($cond)
    {
        static::$orderBy = HtmlHelper::escape($cond);
    }
}