# Data API
data-glhum
v4Gz1oJLDDpgRIt93SwPrEYf0n27h0CGWAm2Cg9fDfcz2HKWe5lMfQE1q03SWfyL


curl --request POST \
  'https://data.mongodb-api.com/app/data-syixb/endpoint/data/v1/action/aggregate' \
  --header 'Content-Type: application/json' \
  --header 'api-key: aOu0gH2lL3XpTC7cHVVchWdf6GOaMflz5makTFWyBWufjuB4UOTUDu1E9HFAYxds' \
  --data-raw '{
      "dataSource": "production",
      "database": "sample_airbnb",
      "collection": "listingsAndReviews",
      "pipeline": [
        {
          "$search": {
            "index": "compound-test",
            "text": {
              "path": "description",
              "query": "baseball"
            }
          }
        },
        {
          "$limit": 5
        },
        {
          "$project": {
            "_id" : 0,
            "name": 1,
            "description": 1,
            "score": { "$meta": "searchScore" }
          }
        }
      ]
  }'


  
