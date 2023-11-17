# AWS DocumentDB Sizing Script

Download the [getDocDBSizing.js](https://raw.githubusercontent.com/itchap/mongodb-guides/main/Sizing%20Scripts/getDocDBSizing.js) script to a server that has network access to the DocumentDB Cluster

Run the following command to connect to the cluster on the admin database and output the sizing information

Depending on the version of your Mongo Shell, run one of these:

mongo --host <hostname>:27017 --ssl --sslCAFile global-bundle.pem --username <username> --password <Password> getMongoData.js > getMongoData.txt

or 

mongosh mongodb://<hostname>:27017/admin --tls --tlsCAFile global-bundle.pem -u <username> -p <password> getMongoData.js > getMongoData.txt

