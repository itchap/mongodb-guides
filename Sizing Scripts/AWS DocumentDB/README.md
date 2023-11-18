# AWS DocumentDB Sizing Script

## Overview

This repository contains a MongoDB sizing script designed for AWS DocumentDB. The script, `getDocDBSizing.js`, retrieves sizing information for each database in a DocumentDB cluster. This README provides instructions on how to download and use the script.

## Instructions

### Step 1: Download the Script

Download the [getDocDBSizing.js]([https://raw.githubusercontent.com/itchap/mongodb-guides/main/Sizing%20Scripts/getDocDBSizing.js](https://github.com/itchap/mongodb-guides/blob/main/Sizing%20Scripts/AWS%20DocumentDB/getDocDBSizing.js)) script to a server that has network access to the DocumentDB cluster.

### Step 2: Connect to the DocumentDB Cluster

Run the following command to connect to the cluster on the admin database and output the sizing information:

#### Using `mongo` (Mongo Shell):
```bash
mongo --host <hostname>:27017 --ssl --sslCAFile global-bundle.pem --username <username> --password <password> getMongoData.js > getMongoData.txt
```
#### Using mongosh (MongoDB Shell):
```bash
mongosh mongodb://<hostname>:27017/admin --tls --tlsCAFile global-bundle.pem -u <username> -p <password> getMongoData.js > getMongoData.txt
```
Replace `<hostname>`, `<username>`, and `<password>` with your DocumentDB cluster details.

### Step 3: Review Sizing Information

The script will output sizing information for the cluster and each database to the `getMongoData.txt` file. Review the contents of this file for a summary of the total data, storage, and index sizes across all databases.

Finally send the `getMongoData.txt` file via email to your MongoDB Sales team for review and pricing.  

## Disclaimer

This script is provided as-is and is not officially supported by AWS or MongoDB. Use it at your own discretion and ensure compatibility with your DocumentDB cluster version and configuration.

For more information on AWS DocumentDB, refer to the [official documentation](https://docs.aws.amazon.com/documentdb/latest/developerguide/what-is.html).
