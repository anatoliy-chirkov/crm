<?php

abstract class ORM
{
    protected $tableName;
    protected $sqlRow;
    protected $field = '*';

    public function select($field = null)
    {
        isset($field)
            ? is_array($field) ? $this->field = implode($field, ', ') : $this->field = $field
            : null
        ;

        empty($this->tableName)
            ? $this->tableName = get_class($this) - 'ORM'
            : null
        ;

        $this->sqlRow = 'select' . $this->field . ' from ' . $this->tableName;

        return $this;
    }

    public function where($field, $value)
    {
        $this->sqlRow = $this->sqlRow . ' where ' . $field;

        is_array($value)
            ? $this->sqlRow = $this->sqlRow . ' in (' . implode($value, ', ') . ')'
            : $this->sqlRow = $this->sqlRow . ' = ' . $value
        ;

        return $this;
    }

    public function andWhere($field, $value)
    {
        $this->sqlRow = $this->sqlRow . ' and ' . $field;

        is_array($value)
            ? $this->sqlRow = $this->sqlRow . ' in (' . implode($value, ', ') . ')'
            : $this->sqlRow = $this->sqlRow . ' = ' . $value
        ;

        return $this;
    }

    public function whereMore($field, $value)
    {
        $this->sqlRow = $this->sqlRow . ' where ' . $field  . ' > ' . $value;

        return $this;
    }

    public function whereLess($field, $value)
    {
        $this->sqlRow = $this->sqlRow . ' where ' . $field  . ' < ' . $value;

        return $this;
    }

    public function whereMoreOrEqual($field, $value)
    {
        $this->sqlRow = $this->sqlRow . ' where ' . $field  . ' >= ' . $value;

        return $this;
    }

    public function whereLessOrEqual($field, $value)
    {
        $this->sqlRow = $this->sqlRow . ' where ' . $field  . ' <= ' . $value;

        return $this;
    }

    public function whereInterval($field, $beforeValue, $afterValue)
    {
        $this->sqlRow = $this->sqlRow . ' where ' . $field  . ' > ' . $beforeValue . ' and < ' . $afterValue;

        return $this;
    }

    public function execute()
    {
        $res = DB::me()->getConnection()->prepare($this->sqlRow);
        $res->execute();

        return $res->fetchAll(PDO::FETCH_ASSOC);
    }
}
