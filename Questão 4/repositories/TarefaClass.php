<?php

include_once(ABSPATH_REPOSITORIES . '/BaseClass.php');

class tarefaClass extends BaseRepository
{
    protected $table = 'tarefas';
    protected $pk = 'id';

    public function all()
    {
        $sql = "select * from $this->table";
        return $this->banco->queryAll($sql);
    }

    public function findById($id)
    {
        $sql = "select * from $this->table where id=?";
        return $this->banco->query($sql, array($id));
    }
	
	public function findByStatus($stt = 'PENDENTE')
    {
        $sql = "select * from $this->table where status=? order by prioridade";
        return $this->banco->queryAll($sql, array($stt));
    }

    public function insert($tarefa)
    {
        $sql = "INSERT INTO $this->table
                (titulo,descricao,prioridade,status)
                VALUES(:titulo,:descricao,999999,'PENDENTE')";
        #var_dump($tarefa);
        $binding = array(
            ':titulo' => $tarefa['titulo'],
            ':descricao' => $tarefa['descricao'],
        );
        return $this->banco->insert($sql, $binding);
    }

    public function update($tarefa)
    {
        $sql = "UPDATE $this->table set titulo= :titulo , descricao= :descricao
						where id = :id ";
        #var_dump($usuario);
        $binding = array(
            ':id' => $tarefa['id'],
            ':titulo' => $tarefa['titulo'],
            ':descricao' => $tarefa['descricao'],
        );
        return $this->banco->update($sql, $binding);
    }
	
	public function prioridade($ids)
    {
        $prioridade=1;
		foreach($ids as $id){
			if(is_numeric($id)){
				echo "<br>".$sql = "UPDATE $this->table set prioridade = $prioridade
							where id =  ".$id;
				$this->banco->update($sql);
				$prioridade++;
			}
		}
    }
	
	public function delete($id)
    {
		$del = "delete from  $this->table where id =  ".$id;
		return $this->banco->delete($del);
    }
}
