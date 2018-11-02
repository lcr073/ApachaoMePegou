<?php
        // Recebe como parametro o nome do container a ser startado
        $nomeContainer = "teste";

	//$StringExec = 'sudo -u root -S bash startHost.sh </home/aluno/passwordfile';
	$StringExec = 'sudo ./startHost.sh';

	echo var_dump($StringExec);

	$saidas = array();

        // Atraves dos parametros recebidos inicia o container correspondente
         shell_exec($StringExec);

//	echo $saidas[0];
	echo "Container iniciado";
?>



