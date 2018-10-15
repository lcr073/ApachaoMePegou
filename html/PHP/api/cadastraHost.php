<?php
/*
 * API DE CADASTRAMENTO DE HOST
 * Parametros esperados de entrada:
 *      *Id Usuario
 *      *Porta SSH
 *      *Porta Web

 *  exemplo json esperado
 *
 *
 {
	"idusuario":"1",
	"nomehost":"docker1",
	"portassh":"5000",
	"portaweb":"5001"
 }
 *
 Saidas:
(201) Se inseriu com sucesso
(403) Não esta logado,parametros faltando,id de dono nao existe.
*/
// Recebe variaveis por Json (Retorna array indexado na variavel $obj)
    include "include/json/json_rec.php";
// Valida no banco as informações recebidas
   include "include/db/connect.php";
//Verifica se existe uma sessão estabelecida
   //include "include/session.php";
    // Verifica se veio algum campo em branco
    if(!(isset($obj['idusuario']) AND isset($obj['portassh']) AND isset($obj['portaweb']))) {
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
        // Verifica se existem o dono
        if(count($result) == 0){
            // Sai e da erro
            http_response_code(403);
            exit("O usuario não existe");
        }

	// Verifica se a porta web ou host ja esta em uso
	try{
		// Verifica no banco se existe alguma porta em uso para as selecionadas
		$stmt = $dbh->prepare("SELECT idhost FROM hosts WHERE porta_ssh = :PORTASSH OR porta_web = :PORTAWEB OR nome_host = :NOMEHOST");

		// bindParam ajuda evitar SQLinjection
		// Vinculando parametros
		$stmt->bindParam(":PORTASSH",$obj['portassh']);
		$stmt->bindParam(":PORTAWEB",$obj['portaweb']);
		$stmt->bindParam(":NOMEHOST",$obj['nomehost']);

		// Realmente realiza a execucao da query
		$stmt -> execute();
			
			//Pega os itens encontrados na query
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			}catch (Exception $e) {
				echo 'Exceção capturada: ', $e->getMessage(), "\n";
				http_response_code(403);
				exit("Erro DB");
		}
		// Verifica se existem portas iguais
		if(count($result) != 0){
		    // Sai e da erro
		    http_response_code(403);
		    exit("Alguma porta / nome de host, ja existe");
		}		
	
        else {
			try{
				//Prepara para a query
				$stmt = $dbh->prepare("INSERT INTO hosts (nome_host, porta_ssh, porta_web, idusuario) VALUES (:NOMEHOST, :PORTASSH,:PORTAWEB, :ID_DONO)");
				
				// bindParam ajuda evitar SQLinjection
				// Vinculando parametros
				$stmt->bindParam(":NOMEHOST",$obj["nomehost"]);
				$stmt->bindParam(":PORTASSH",$obj["portassh"]);
				$stmt->bindParam(":PORTAWEB",$obj["portaweb"]);
				$stmt->bindParam(":ID_DONO",$obj["idusuario"]);

				// Realmente realiza a execucao da query
				$stmt -> execute();
			}catch (Exception $e) {
				echo 'Exceção capturada: ', $e->getMessage(), "\n";
				http_response_code(403);
				exit("Erro DB");
			}			
			// Retorna o codigo 201 (Criado)
			http_response_code(201);
			exit("Host cadastrado");
			
        }
    }
?>
