#!/bin/bash


_DATE=`date +%d%m%Y`

wa2_cnt=$(/bin/cat /backup/expdp/arch199/WA2_${_DATE}.txt |grep -v "USER_NAME" |wc -l | sed ':a;s/\B[0-9]\{3\}\>/,&/;ta' )
wa2r_cnt=$(/bin/cat /backup/expdp/arch199/WA2R_${_DATE}.txt |grep -v "ACCOUNT_NUM" |wc -l | sed ':a;s/\B[0-9]\{3\}\>/,&/;ta' )

#awk '{ printf "%'\''d\n", $1 }'


sss2=$(echo ${wa2_cnt} | awk     '{ printf "WA 2 From   BCS : " $1 " rows" }'  |sed -e 's/ /%20/g')
sss2r=$(echo ${wa2r_cnt} | awk   '{ printf "WA 2 Reject : " $1 " rows" }' | sed -e 's/ /%20/g')

ihead=$(/bin/cat /u01/oracle/tools/wa/wa2_alert_head.txt)

sss=$(echo ${ihead} aod ${sss2} ${sss2r} |sed -e 's/ /%20/g')

curl xx.xx.xx.157/alert_radius/AlertDeveloper.php?content="${sss}"

