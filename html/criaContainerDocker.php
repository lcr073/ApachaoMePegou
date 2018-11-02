<?php
	// Recebendo parametros usados para criacao do conteiner
	$nomeContainer = 'teste1';
	$portaWeb = 5555;
	$portaSsh = 6666;
	$tipoContainer = 'apache'; // apache ou nginx


	// Analisando tempo de execucao
	$time_preExec = microtime(true);

	$saidas = array();

	// Executa o comando para chamar o bash que cria container
	//exec('./managerHost.sh 3333 4444 teste1 nginx',$saidas);
	exec("./managerHost.sh $portaWeb $portaSsh $nomeContainer $tipoContainer",$saidas);

 echo "./managerHost.sh $portaWeb $portaSsh $nomeContainer $tipoContainer";
	echo $saidas[0];
	if($saidas[0] == 'Opcao invalida'){
		echo "Ocorreu algum erro na criacao do container !!";
	}

//	echo var_dump($saidas);

	// Analisa saida
		// Aguarda ate a execucao do container e ele esta pronto
			// Criado com sucesso

		// Erro na execucao

	$time_postExec = microtime(true);
	$exec_time = $time_postExec - $time_preExec;

	echo $exec_time;

?>

