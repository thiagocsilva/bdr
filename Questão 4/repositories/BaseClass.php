<?php

include_once(ABSPATH_INC . '/Banco.php');
include_once(ABSPATH_REPOSITORIES . '/ICrud.php');

class BaseRepository implements ICrud
{
    protected $table = 'default';
    protected $pk = 'id';
    protected $banco;

    public function __construct()
    {
        $this->banco = Banco::getInstance();
    }

    public function all()
    {
        $sql = "select * from $this->table ";
        return $this->banco->queryAll($sql);
    }


    /**
     * @param $take int quantidade maxima de rows buscados
     * @return array
     */
    public function allTake($take)
    {
        $sql = "select * from $this->table limit $take";
        return $this->banco->queryAll($sql);
    }

    public function findByIds($arr)
    {
        if (empty($arr)) return array();
        $sql = "select * from $this->table where $this->pk in ";
        $sql .= '(' . str_repeat('?,', count($arr) - 1) . '?)';
        return $this->banco->queryAll($sql, $arr);
    }

    public function find($id)
    {
        $sql = "select * from $this->table where $this->pk =? limit 1";
        return $this->banco->query($sql, array($id));
    }

    public function findBySlug($slug)
    {
        $sql = "select * from $this->table where slug =? limit 1";
        return $this->banco->query($sql, array($slug));
    }

    public function count()
    {
        $sql = "select count(*) from $this->table";
        return $this->banco->queryAll($sql);
    }

    public function delete($id)
    {
        $sql = "delete from $this->table where $this->pk = ?";
        return $this->banco->delete($sql, array($id));
    }

    public function deletes($ids = array())
    {
        $sql = "delete from $this->table where $this->pk in ";
        $sql .= '(' . str_repeat('?,', count($ids) - 1) . '?)';
        return $this->banco->delete($sql, $ids);
    }

    public function lastInsert()
    {
        $sql = "select max($this->pk) $this->pk from  $this->table ";
        $retorno = $this->banco->query($sql);
        return $retorno[$this->pk];
    }

    public function  lastInsertId()
    {
        return $this->banco->lastInsertId();
    }
}	