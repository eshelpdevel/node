###############################################################################################################
# Date          |    Type    |   Version                                                                      # 
############################################################################################################### 
# 07-05-2025    |   Create   |  1.1.0705.2025                                                                 #
############################################################################################################### 

NAMA_APLIKASI=("main") # Daftar nama aplikasi

cek_status() {

  STATUS=$(pm2 jlist | jq -r ".[] | select(.name == \"$aplikasi\") | .pm2_env.status")  
  start_date="$(date '+%Y-%m-%d %H:%M:%S')"
  
  LOGS=''
  if [ "$STATUS" == "stopped" ]; then
  
    pm2 start "$aplikasi" debug 1> /dev/null 2> /dev/null

    end_date="$(date '+%Y-%m-%d %H:%M:%S')"
  else
    end_date="$(date '+%Y-%m-%d %H:%M:%S')"
    
  fi
    # Pernyataan INSERT SQL
    SQL_STATEMENT="INSERT INTO cc_pm2_log (pm2_name,response,logs,start_time, end_time) VALUES ('$aplikasi','$STATUS','$LOGS','$start_date','$end_date')"

    # Eksekusi perintah MySQL
    mysql -u es -p0218Galunggung db_wom -e "$SQL_STATEMENT"
}

  for aplikasi in "${NAMA_APLIKASI[@]}"; do
    cek_status "$aplikasi"
  done
  exit 0
