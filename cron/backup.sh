## Creado: 04/08/2017 Creantis
## Cron para generar backup de Base de Datos y Proyecto vtiger
## Se almacena en la raiz del proyecto en la carpeta backup, previamente creada
##
#!/bin/sh
export VTIGERCRM_ROOTDIR=`dirname "$0"`/..
export USE_PHP=php
export FECHA=$(date +%Y%m%d_%H%M%S)
##DBNAME => Nombre de la Base de Datos
export DBNAME="vtigercrm701_kuresa01"
##DBNAMEBCK => Nombre con el que se guarda el backup del aBD
export DBNAMEBCK="KURESA_DB_"$FECHA
##PROJECT => Nombre del proyecto
export PROJECT="KURESA_APP_701kuresa01"
##NAMEAPP => Nombre con el que se guarda el backup del proyecto
export NAMEAPP=$PROJECT"_"$FECHA
###PARAMETROS DE CONFIGURACION MySql
export DB_PORT="3306"
export DB_HOST="192.168.0.110"
export DB_USER="root"
export DB_PWD="123456"

cd $VTIGERCRM_ROOTDIR
echo "========= INICIO BACKUP === F: "$FECHA >> logbackup.txt
## -u => usuario_base_datos
## -p => password_base_datos
echo "Conexion MySQL: mysqldump -P"$DB_PORT" -h"$DB_HOST" -u"$DB_USER" -p"$DB_PWD" --opt "$DBNAME >> logbackup.txt
mysqldump -P$DB_PORT -h$DB_HOST -u$DB_USER -p$DB_PWD --opt $DBNAME > $VTIGERCRM_ROOTDIR/backup/$DBNAMEBCK".sql"

cd $VTIGERCRM_ROOTDIR/backup
zip $DBNAMEBCK.zip *.sql
rm -f *.sql

cd $VTIGERCRM_ROOTDIR
echo "Cambio de RUTA para backup de proyecto a > "$VTIGERCRM_ROOTDIR >> logbackup.txt
## Comprime todo el proyecto excluyendo carpetas: backup, test/templates_c/v7
zip -r $NAMEAPP.zip * -x backup/**\* -x test/templates_c/v7/**\* -x *.zip
## Mueve el ZIP del proyecto a la carpeta backup
mv $NAMEAPP.zip backup
echo $NAMEAPP".zip > MOVIDO A /backup > " >> logbackup.txt

export FECHAFIN=$(date +%Y%m%d_%H%M%S)
echo "========== FIN BACKUP === F: "$FECHAFIN >> logbackup.txt

echo "========= INICIO FTP UPLOAD === BD.zip F: "$FECHAFIN >> logbackup.txt

cd backup
##Envio por FTP
export HOST="ftp.creantis.net"
export USER="backup"
export PWD="CRMbu17"
export FILE1=$DBNAMEBCK".zip"
export FILE2=$NAMEAPP".zip"

echo "ZIP A SUBIR FTP BD> 1 > "$FILE1 >> ../logbackup.txt
ftp -n $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PWD
put $FILE1
quit
END_SCRIPT

export FECHAINICIO=$(date +%Y%m%d_%H%M%S)
echo "========= INICIO FTP UPLOAD === APP.zip F: "$FECHAINICIO >> ../logbackup.txt
echo "ZIP A SUBIR FTP APP> 2 > "$FILE2 >> ../logbackup.txt
ftp -n $HOST <<END_SCRIPT
quote USER $USER
quote PASS $PWD
put $FILE2
quit
END_SCRIPT

export FECHAFINFTP=$(date +%Y%m%d_%H%M%S)
echo "========= FIN FTP UPLOAD === F: "$FECHAFINFTP >> ../logbackup.txt
exit 0
