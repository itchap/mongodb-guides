# Generate load

### Set up the POC Driver
cd ~/Documents/GitHub/POCDriver/bin
connStr="mongodb+srv://admin:NokiaN900@production.6ky25.mongodb.net/?retryWrites=true"

### Ingest Rate Performance
##### 1KB inserted records
java -jar POCDriver.jar -c $connStr -t 4 -e -d 600 -f 25 -a 5:5 --depth 2 -x 3
##### 10KB inserted records
java -jar POCDriver.jar -c $connStr -t 4 -e -d 600 -f 234 -a 20:20 --depth 2 -x 6
##### 50KB inserted records
java -jar POCDriver.jar -c $connStr -t 4 -e -d 600 -f 1692 -a 10:10 --depth 2 -x 8

java -jar POCDriver.jar -c $connStr -k 20 -i 10 -u 10 -b 20
