<?php 

namespace Models;

use Aura\SqlQuery\QueryFactory;
use PDO;

class QueryBuilder {

	private $pdo, $queryFactory;

	public function __construct() {
		$this->pdo = new PDO("mysql:host=localhost;dbname=test3", "mad", "");

		$this->queryFactory = new QueryFactory('mysql');		
	}

	public function getAll($table, $cols, $condition = null) {
		

		$select = $this->queryFactory->newSelect();

		$select->from($table)->cols($cols);

		if ($condition) {
			$select->where($condition);
		}
		
		$statement = $this->pdo->prepare($select->getStatement());

		$statement->execute($select->getBindValues());
  		
		$data = $statement->fetchAll(PDO::FETCH_ASSOC);

		return $data;
	}

	public function getOne($table, $cols, $condition = null) {	

		
		$select = $this->queryFactory->newSelect();

		$select->from($table)->cols($cols);

		if ($condition) {
			$select->where($condition);
		}

		$statement = $this->pdo->prepare($select->getStatement());

		$statement->execute($select->getBindValues());

		$data = $statement->fetch(PDO::FETCH_ASSOC);

		return $data;
	}

	
	public function insert($table, $cols_values) {
		
		$insert = $this->queryFactory->newInsert();

		$insert->into($table)->cols($cols_values);

		$statement = $this->pdo->prepare($insert->getStatement());
		// var_dump($statement); die;
		$statement->execute($insert->getBindValues());
	}

	public function update($table, $cols, $condition) {

		$update = $this->queryFactory->newUpdate();

		$update->table($table)->cols($cols)->where($condition);

		$statement = $this->pdo->prepare($update->getStatement());

		$statement->execute($update->getBindValues());		

	}

	public function delete ($table, $condition) {
		
		$delete = $this->queryFactory->newDelete();

		$delete->from($table)->where($condition);

		$statement = $this->pdo->prepare($delete->getStatement());

		$statement->execute($delete->getBindValues());
	}


}

?>