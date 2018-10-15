<?php
/*
 * API DE ATIVACAO DE CONTAINER DO USUARIO
 * Parametros esperados de entrada:
 *      * Id usuario
 *      
 *  exemplo json esperado
 *
 *
 {
	"idusuario":"2"
	"idhost":"1"
 }
 *
 Saidas:
(200) Retorno das informaçoes do(s) hosts
(204) Dono não possui hosts
(403) Não esta logado,id de dono nao veio,id de dono nao existe.
*/
// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";
// Valida no banco as informações recebidas
   include "include/db/connect.php";
//Verifica se existe uma sessão estabelecida
   include "include/session.php";
	
    // Verifica se veio algum campo em branco
    if(!isset($obj['idusuario'])) {
        // Faltou algum campo então nao é aprovada a movimentacao
        http_response_code(403);
        exit("Falta de parametros");
    }
	
    // Todos os campos vieram preenchidos
    else{
		try{
			// Verifica no banco se existe usuario com aquele id
			$stmt = $dbh->prepare("SELECT idusuario FROM usuarios WHERE idusuario = :ID_DONO ");
			
			// bindParam ajuda evitar SQLinjection
			// Vinculando parametros
			$stmt->bindParam(":ID_DONO",$obj['idusuario']);
			// Realmente realiza a execucao da query
			$stmt -> execute();
			
			//Pega os itens encontrados na query
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}catch (Exception $e) {
			echo 'Exceção capturada: ', $e->getMessage(), "\n";
			http_response_code(403);
			exit("Erro DB");
		}
		// Verifica se existe o dono
		if(count($result) == 0){
			// Sai e da erro
			http_response_code(403);
			exit("O dono não existe");
		}
		else{
		
			try{		
				//Prepara para a query
				$stmt = $dbh->pre2pare("SELECT * FROM hosts WHERE idusuario = :ID_DONO");
				
				// bindParam ajuda evitar SQLinjection
				// Vinculando parametros
				$stmt->bindParam(":ID_DONO",$obj["idusuario"]);
				// Realmente realiza a execucao da query
				$stmt -> execute();
				
				//Pega os itens encontrados na query
				$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			}catch (Exception $e) {
				echo 'Exceção capturada: ', $e->getMessage(), "\n";
				http_response_code(403);
				exit("Erro DB");
			}
			// Verifica se existem imoveis
			if(count($result) == 0){
				//Retorna o codigo 204 (Vazio)
				http_response_code(204);
				exit();
			}
			else {
				//Retorna o codigo 200 (OK)
				http_response_code(200);
				echo json_encode($result);
			}
		}
		
	}
?>
