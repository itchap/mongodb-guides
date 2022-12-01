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

### Realtime load Generation
java -jar POCDriver.jar -c $connStr -k 20 -i 10 -u 10 -b 20


### Slow Running Queries
cd /Users/itchap/Documents/GitHub/mdb-slow-running-queries
./run-slow-queries.sh mongodb+srv://production.6ky25.mongodb.net/ itchap NokiaN900

### Performance Advisor queries
mongosh "mongodb+srv://production.6ky25.mongodb.net/myFirstDatabase" --apiVersion 1 --username admin

for (i=1; i<=10000; i++) {
   start = new Date().getTime();
   db.customers.update({
      'region': i,
      'address.state': 'UT',
      'policies': {$elemMatch: {'policyType': 'life', 'insured_person.smoking': true}},
      'yob': {$gte: ISODate('1990-01-01'), $lte : ISODate('1990-12-12')},
      'gender': 'Female'
   },
   { $set: { "policies.$[elem].risk" : 300 } },
   {
      multi: true,
      arrayFilters: [ { "elem.policyType": "life" } ]
   });
   print(i, ". time (ms): ", ((new Date().getTime())-start));
}
