<?php
include('ADOdb-master/adodb.inc.php');

class database{
	private $HOST = "localhost";
	private $USER = "root";
	private $PASS = "";
	private $BANCO = "rspainel";
	private $operacao;
	public $tabela;
	public $erro = null;
	public $indicesTabelas = array();
	public $indicesColunas = array();
	private $valoresPost = array();
	private $valoresInsercao = array();
	public $recebeRegistros = array();
	private $campoChave;
	private $valorChave;
	private $column;
	private $clause = "";
	public $idInsert;
	
	function __construct($argumentos){
		$this->obterTabelas();
		$this->operacao = $argumentos["configuracoes"]["operacao"];
		$this->tabela = $this->indicesTabelas[$argumentos["configuracoes"]["tabela"]];
		$this->valoresPost = array_key_exists("valores",$argumentos) ? $argumentos["valores"] : null;
		$this->obtemColunasDb();
		if(array_key_exists("condicao",$argumentos)){
			$this->campoChave = $argumentos["condicao"]["campo"];
			$this->valorChave = $argumentos["condicao"]["valor"];
		}
		if(array_key_exists("clause",$argumentos)){
			$this->clause = $argumentos["clause"];	
		}
		if(array_key_exists("column",$argumentos)){
			$this->column = $argumentos["column"] == "all" ? "*" : $argumentos["column"];
		}
		switch($this->operacao){
			case 1:
				$this->insert();
			break;
			case 2:
				$this->update();
			break;
			case 3:
				$this->delete();
			break;
			case 4:
				$this->select();
			break;
			case 5:
				$this->deleteDefinitivo();
			break;
			case 6:
				$this->updateUnique();
			break;
		}
	}
	
	public function insert(){
		$chaves = array_keys($this->valoresPost);
		foreach($chaves as $chave){
		$this->valoresInsercao[] = $this->valoresPost[$chave];}
		$this->valoresInsercao["display"] = 0;
		$valoresString = implode("','",$this->valoresInsercao);
		$valoresInsercao = "'".$valoresString."'";
		$query = "insert into $this->tabela values(0,$valoresInsercao)";
		$db = $this->connect();
		if($db->Execute($query) === false){
			$this->erro = $db->ErrorMsg();
		}else{
			$this->idInsert = $db->insert_Id();
		}
	}
	public function update(){
		$chaves = array_keys($this->valoresPost);
		foreach($chaves as $chave){
		$this->valoresInsercao[] = $this->valoresPost[$chave];}
		$obtemColunas = "SHOW COLUMNS FROM $this->tabela";
		$db = $this->connect();
		$rs = $db->Execute($obtemColunas);
		$obtemColunas = $rs->GetRows();
		array_shift($obtemColunas);
		$listaDadosInsercao = array();
		for($i=0; $i < count($this->valoresInsercao); $i++){
			$listaDadosInsercao[$obtemColunas[$i][0]] = $this->valoresInsercao[$i];
		}
		if($db->AutoExecute($this->tabela, $listaDadosInsercao, 'UPDATE', "$this->campoChave = $this->valorChave") === false){
			$this->erro = $db->ErrorMsg();
		}
	}
	public function updateUnique(){
		$db = $this->connect();
		if($db->AutoExecute($this->tabela, $this->valoresPost, 'UPDATE', "$this->campoChave = $this->valorChave") === false){
			$this->erro = $db->ErrorMsg();
		}
	}
	public function delete(){
		$campoDeleta["display"] = 1;
		$db = $this->connect();
		if($db->AutoExecute($this->tabela, $campoDeleta, 'UPDATE', "$this->campoChave = $this->valorChave") === false){
			$this->erro = $db->ErrorMsg();
		}
	}
	public function deleteDefinitivo(){
		$db = $this->connect();
		$query = "delete from $this->tabela where $this->campoChave = $this->valorChave";
		if($db->Execute($query) === false){
			$this->erro = $db->ErrorMsg();
		}
	}
	public function select(){
		$coluna = $this->column;
		$query = "SELECT $coluna FROM $this->tabela WHERE display = 0";
		if($this->clause != ""){
			$query.= " AND $this->clause";
		}
		$db = $this->connect();
		$consulta = $db->Execute($query);
		if(!$consulta){
			$this->erro = $db->ErrorMsg();
		}else{
			while(!$consulta->EOF){
				$this->recebeRegistros[] = $consulta->fields;
				$consulta->MoveNext();
			}
		}
	}
	private function connect(){
		$db = newAdoConnection('mysqli');
		$db->PConnect($this->HOST, $this->USER, $this->PASS, $this->BANCO);
		if (!$db) die("Falha na conexão com o banco de dados");
		$db->Execute("set names 'utf8'"); 
		return $db;
	}
	private function obterTabelas(){
		$conexao = $this->connect();
		$indicesTabelas = array();
		$queryTabelas = "SHOW TABLES FROM ".$this->BANCO;
		$rs = $conexao->Execute($queryTabelas);
		$obtemRegistros = $rs->GetRows();
		for($i=0; $i < count($obtemRegistros); $i++){
			array_push($indicesTabelas, $obtemRegistros[$i][0]);
		}
		$this->indicesTabelas = $indicesTabelas;
	}
	public function obtemColunasDb(){
		$indicesColunas = array();
		$obtemColunas = "SHOW COLUMNS FROM ".$this->tabela;
		$db = $this->connect();
		$rs = $db->Execute($obtemColunas);
		$obtemRegistros = $rs->GetRows();
		for($i=0; $i < count($obtemRegistros); $i++){
			array_push($indicesColunas, $obtemRegistros[$i][0]);
		}
		$this->indicesColunas = $indicesColunas;
	}
}
?>