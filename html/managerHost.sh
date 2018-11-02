
#!/bin/bash
# Cria container docker com a porta, ip e nome passados como parametros
# Os parametros sao:
# $1 - porta utilizada pelo container (web)
# $2 - porta utilizada pelo container para ssh
# $3 - usuario dono do container
# $4 - tipo de servidor web desejado (uebiancamargo nginx - uebiancamargo apache)

# Chamando na hora de executar o script ./managerHost.sh 4321 4322 teste1 lcr073/servidoruebiancamarg (nginx)/ lcr073/servidoruebiancamargolightapache

# Debug variaveis
echo s1: $1
echo s2: $2
echo s3: $3
echo s4: $4

if [ $4 == 'apache' ]
then
	echo Apache
#	sudo docker run -it -p $1:80 -p $2:22  --name $3 lcr073/servidoruebiancamargolightapache:1.0
elif [ $4 == 'nginx' ]
then
	echo Nginx
#	sudo docker run -it -p $1:80 -p $2:22  --name $3 lcr073/servidoruebiancamargo:1.8
else
	echo Opcao invalida
fi





