<?php

require_once './config.php';

class Model {
    
    public static $Host = HOST;
    public static $User = USER;
    public static $Pass = PASS;
    public static $Dbname = BASE;
    public static $Port = PORT;
    private static $Connect = null;

    public static $db;
    
    public function __construct(){
        if(!isset(self::$db)){ 
            try{
                $conn = new PDO("mysql:host=".self::$Host.":".self::$Port.";dbname=".self::$Dbname, self::$User, self::$Pass); 
                $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db = $conn;
            }catch(PDOException $e){
                die("Failed to connect with MySQL----: " . $e->getMessage());
            }
        }
    }

    /**
    * Destructor.
    */
    public function __destruct(){
        
    }
    
    private static function Conectar() {
        try {
            if(self::$Connect == null):
                self::$Connect = new PDO('mysql:host=' . self::$Host .';dbname='.self::$Dbname, self::$User, self::$Pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                self::$Connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$Connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);   
            endif;            
        } catch (Exception $ex) {
            echo 'Mensagem: ' . $ex->getMessage();
        }       
        return self::$Connect;
    }
    
    public function getConn() {
        if($_SERVER['HTTP_HOST']=="cpro48708.publiccloud.com.br"){
            return self::conectaDiagOnline();
          }else{
            return self::Conectar();
          }
    }


    private static function conectaDiagOnline(){
        $host="localhost";
        $banco="banco2";
        $user="aluno";
        $pass="123";
        try{
            $conn = new PDO("mysql:host=$host;dbname=$banco",$user,$pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Deu certo a conexão<br>";
            return $conn;
        }catch(PDOException $erro){
            echo "Erro ".$erro->getMessage();
        }
    }
    public function multisql($sql){ 
        $comand = self::$db->prepare($sql);
        
        try{
           $comand->execute();
        }catch(PDOException $erro){
            echo "Erro ".$erro->getMessage();
        } 
    }
    //apenas para arquivos
    public function multi($sql){ 
        $sqlScript = file($sql);
        $query = '';
        foreach ($sqlScript as $line)	{
            $startWith = substr(trim($line), 0 ,2);
            $endWith = substr(trim($line), -1 ,1);
            if (empty($line) || $startWith == '--' || $startWith == '/*' || $startWith == '//') {
                continue;
            }

            $query = $query . $line;
            if ($endWith == ';') {
                //mysqli_query(self::$db,$query) or die('<div class="error-response sql-import-response">Problem in executing the SQL query <b>' . $query. '</b></div>');
                $comand = self::$db->prepare($query);
                
                try{
                    $comand2 = $comand->execute();
                }catch(PDOException $erro){
                    //echo "Erro ".$erro->getMessage();
                }
                $query= '';
            }
        }
    }
    
    public function select($sql){
        $data=null;
        $query = self::$db->prepare($sql);
        try {
            $query->execute();
            $data = $query->fetchAll();
        } catch (Exception $e) {
            echo 'Exceção capturada: ',  $e->getMessage(), "\n";
        //} finally {
            //$data=null;
        }

        return $data;
    }
    
    /*
     * Returns rows from the database based on the conditions 
     * @param string name of the table 
     * @param array select, where, order_by, limit and return_type conditions 
     */ 
    public function getRows($table,$conditions = array()){ 
        $sql = 'SELECT '; 
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*'; 
        $sql .= ' FROM '.$table; 
        if(array_key_exists("where",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['where'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." = '".$value."'"; 
                $i++; 
            } 
        } 
        if(array_key_exists("whereLike",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['whereLike'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." like '%".$value."%'"; 
                $i++; 
            } 
        } 
        if(array_key_exists("whereISNOT",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['whereISNOT'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." ".$value." "; 
                $i++; 
            } 
        } 
         
        if(array_key_exists("order_by",$conditions)){ 
            $sql .= ' ORDER BY '.$conditions['order_by'];  
        } 

        if(array_key_exists("group_by",$conditions)){ 
            $sql .= ' GROUP BY '.$conditions['group_by'];  
        } 
         
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];  
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
            $sql .= ' LIMIT '.$conditions['limit'];  
        } 
        //echo $sql;
        $query = self::$db->prepare($sql); 
        $query->execute(); 

        //var_dump($query);
         
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){ 
            switch($conditions['return_type']){ 
                case 'count': 
                    //$data = $query->rowCount(); 
                    $data = $query->fetch(PDO::FETCH_ASSOC); 
                    break; 
                case 'single': 
                    $data = $query->fetch(PDO::FETCH_ASSOC); 
                    break; 
                case 'object': 
                    $data = $query->fetchAll(PDO::FETCH_OBJ);
                    break;     
                default: 
                    $data = ''; 
            } 
            //var_dump($data);
        }else{ 
            if($query->rowCount() > 0){ 
                $data = $query->fetchAll(); 
            } 
        } 
        //var_dump($data);
        return !empty($data)?$data:false; 
    } 

    public function getById($table,$conditions = array()){ 
        $sql = 'SELECT '; 
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*'; 
        $sql .= ' FROM '.$table; 
        if(array_key_exists("where",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['where'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." = '".$value."'"; 
                $i++; 
            } 
        } 
        if(array_key_exists("whereLike",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['whereLike'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." like '%".$value."%'"; 
                $i++; 
            } 
        } 
        if(array_key_exists("whereISNOT",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['whereISNOT'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." ".$value." "; 
                $i++; 
            } 
        } 
         
        if(array_key_exists("order_by",$conditions)){ 
            $sql .= ' ORDER BY '.$conditions['order_by'];  
        } 

        if(array_key_exists("group_by",$conditions)){ 
            $sql .= ' GROUP BY '.$conditions['group_by'];  
        } 
         
        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];  
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){ 
            $sql .= ' LIMIT '.$conditions['limit'];  
        } 
         
        $query = self::$db->prepare($sql); 
        $query->execute(); 

        //var_dump($query);
         
        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){ 
            switch($conditions['return_type']){ 
                case 'count': 
                    //$data = $query->rowCount(); 
                    $data = $query->fetch(PDO::FETCH_ASSOC); 
                    break; 
                case 'single': 
                    $data = $query->fetch(PDO::FETCH_ASSOC); 
                    break; 
                case 'object': 
                    $data = $query->fetchAll(PDO::FETCH_OBJ);
                    break;     
                default: 
                    $data = ''; 
            } 
            //var_dump($data);
        }else{ 
            if($query->rowCount() > 0){ 
                $data = $query->fetchAll(); 
            } 
        } 
        //var_dump($data);
        return !empty($data)?$data:false; 
    } 
	function descobreTotal($table,$conditions = array()){
        $sql = "select count(*) as total FROM ".$table; 
        if(array_key_exists("where",$conditions)){ 
            $sql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['where'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $sql .= $pre.$key." = '".$value."'"; 
                $i++; 
            } 
        } 

        $query = self::$db->prepare($sql); 
        $query->execute(); 
        $data = $query->fetch(PDO::FETCH_ASSOC); 
        return $data;
    }
     
    /* 
     * Insert data into the database 
     * @param string name of the table 
     * @param array the data for inserting into the table 
     */ 
    public function insert($data,$table){ 
        //print("dados");
        //print_r($data);
        $table = strtolower($table);
        $retval = [];
        if(!empty($data) && is_array($data)){ 
            //print("--------------------AQUIiiiii");
            $columns = ''; 
            $values  = ''; 
            $i = 0; 
            // if(!array_key_exists('created',$data)){ 
            //     $data['created'] = date("Y-m-d H:i:s"); 
            // } 
            // if(!array_key_exists('modified',$data)){ 
            //     $data['modified'] = date("Y-m-d H:i:s"); 
            // } 
 
            $columnString = "`".implode('`,`', array_keys($data))."`"; 
            $valueString = ":".implode(',:', array_keys($data)); 
            $sql = "INSERT INTO ".$table." (".$columnString.") VALUES (".$valueString.")"; 
            $query = self::$db->prepare($sql); 
            foreach($data as $key=>$val){ 
                 $query->bindValue(':'.$key, $val); 
            } 
            
            //$query->debugDumpParams();
            //die();

            try {
                $insert = $query->execute(); 
                $retval['status'] = true;
                $retval['message'] = "ok";
                $retval['result'] = $insert?self::$db->lastInsertId():false; 
            } catch (Exception $e) {
                $retval['status'] = false;
                $retval['message'] = "\n Código do erro: ".$e->getMessage();
                $retval['result'] = 0;
                return $retval;
            //} finally {
                //return $retval;
            }
        
        }else{ 
            $retval['status'] = false;
            $retval['message'] = "error";
            $retval['result'] = 0;
        } 
        return $retval; 
    } 
     
    /* 
     * Update data into the database 
     * @param string name of the table 
     * @param array the data for updating into the table 
     * @param array where condition on updating data 
     */ 
    public function update($data,$conditions,$table){ 
        //var_dump($conditions);
        $retval['status'] = false;
        $retval['message'] = "error";
        $idUpdate = 0;
        $retval['result'] = 0;

        if(!empty($data) && is_array($data)){ 
            $colvalSet = ''; 
            $whereSql = ''; 
            $i = 0; 
            // if(!array_key_exists('modified',$data)){ 
            //     $data['modified'] = date("Y-m-d H:i:s"); 
            // } 
            foreach($data as $key=>$val){ 
                $pre = ($i > 0)?', ':''; 
                $colvalSet .= $pre.$key."='".$val."'"; 
                $i++; 
            } 
            if(!empty($conditions)&& is_array($conditions)){ 
                $whereSql .= ' WHERE '; 
                $i = 0; 
                //print_r($conditions);
                foreach($conditions['where'] as $key => $value){ 
                    $pre = ($i > 0)?' AND ':''; 
                    $whereSql .= $pre.$key." = '".$value."'"; 
                    $i++; 
                    if($key=='id'){
                        $idUpdate=$value;
                    }
                } 
            } 
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql; 
            //versao
            //account
            //echo $sql;

            $query = self::$db->prepare($sql); 

            try {
                $update = $query->execute(); 
                $retval['status'] = true;
                $retval['message'] = "ok";
                $retval['result'] = $idUpdate; 
            } catch (Exception $e) {
                $retval['status'] = false;
                $retval['message'] = "\n Código do erro: ".$e->getMessage();
                $retval['result'] = $idUpdate;
            //} finally {
                return $retval;
            }

        }
        return $retval;
    } 
    
      /* 
     * Disable record on the database 
     * @param string name of the table 
     * @param array the data for updating into the table 
     * @param array where condition on updating data 
     */ 
    public function disable($data,$conditions,$table){ 
        if(!empty($data) && is_array($data)){ 
            $colvalSet = ''; 
            $whereSql = ''; 
            $i = 0; 
            if(!array_key_exists('modified',$data)){ 
                $data['modified'] = date("Y-m-d H:i:s"); 
            } 
            foreach($data as $key=>$val){ 
                $pre = ($i > 0)?', ':''; 
                $colvalSet .= $pre.$key."='".$val."'"; 
                $i++; 
            } 
            if(!empty($conditions)&& is_array($conditions)){ 
                $whereSql .= ' WHERE '; 
                $i = 0; 
                foreach($conditions as $key => $value){ 
                    $pre = ($i > 0)?' AND ':''; 
                    $whereSql .= $pre.$key." = '".$value."'"; 
                    $i++; 
                } 
            } 
            $sql = "UPDATE ".$table." SET ".$colvalSet.$whereSql; 
            //versao
            //account
            //echo $sql;
            //die();
            $query = self::$db->prepare($sql); 
            $update = $query->execute(); 

            if($query->rowCount()==1){
                $retval['status'] = true;
                $retval['message'] = "ok";
                $retval['result'] = 1; 
            }else{
                $retval['status'] = false;
                $retval['message'] = "\n Código do erro: ".$sql;
                $retval['result'] = 0;
            }
            return $retval;
            //return $update?$query->rowCount():false; 
        }else{ 
            $retval['status'] = false;
            $retval['message'] = "\n Código do erro: sql vazio";
            $retval['result'] = 0;
            return $retval;
        } 
    } 
     
    /* 
     * Delete data from the database 
     * @param string name of the table 
     * @param array where condition on deleting data 
     */ 
    public function delete($conditions,$table){ 
        $whereSql = ''; 
        if(!empty($conditions)&& is_array($conditions)){ 
            $whereSql .= ' WHERE '; 
            $i = 0; 
            foreach($conditions['where'] as $key => $value){ 
                $pre = ($i > 0)?' AND ':''; 
                $whereSql .= $pre.$key." = '".$value."'"; 
                $i++; 
            } 
        } 
        $sql = "DELETE FROM ".$table.$whereSql; 
        //echo $sql ;
        try {
            $delete = self::$db->exec($sql); 
            if($delete){
                $retval['status'] = true;
                $retval['message'] = "ok";
                $retval['result'] = 0; 
            }else{
                $retval['status'] = false;
                $retval['message'] = "\n Código do erro: ".$delete;
                $retval['result'] = 0;
            }
            
        } catch (Exception $e) {
            $retval['status'] = false;
            $retval['message'] = "\n Código do erro: ".$e->getMessage();
            $retval['result'] = 0;
        //} finally {
            return $retval;
        }
    
        return $retval; 

    }

    public function deleteAll($sql){ 
        $data=null;
        $query = self::$db->prepare($sql); 
        try {
            $query->execute(); 
        } catch (Exception $e) {
            echo 'Exceção capturada no delete All: ',  $e->getMessage(), "\n";
        //} finally {
            //$data=null;
        }
         
        return $data; 
    } 

    public function findAllGrupos() {
        $sql = "SELECT group FROM people GROUP BY group";
        $stm = self::$db->prepare($sql); 
        $stm->execute();
        return $stm->fetchAll();
    }

    public function converte($dado){
        // $json = array(
        //     'Nome ' => $dado['name']
        // );

        $json = array(
            'Nome ' => $dado->name
        );
        return json_encode ($json);
    }
    
}