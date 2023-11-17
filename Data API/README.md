# Data API
data-tngxw
lhpM7ZkaDwRsu6AdMFGBAfdXz2NNC9uhAH1YzQJLDmyRaw4BOLbJeER3F59kunRF
dev / prod



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


  
