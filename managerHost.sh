
#!/bin/bash
# Cria container docker com a porta, ip e nome passados como parametros
# Os parametros sao:
# $1 - porta utilizada pelo container (web)
# $2 - porta utilizada pelo container para ssh
# $3 - usuario dono do container
# $4 - tipo de servidor web desejado (uebiancamargo nginx - uebiancamargo apache)


# Chamando na hora de executar o script ./managerHost.sh '4321' '4322' 'teste1' 'uebianapache'/ 'uebiannginx'
docker run -it -p $1:80 $2:22  --name $2 $3

