# Data API

curl --request POST \
  'https://data.mongodb-api.com/app/data-scahn/endpoint/data/v1/action/aggregate' \
  --header 'Content-Type: application/json' \
  --header 'api-key: uFzpO0r2JFyoTD6W5ta1XUorqZQMsY7eeGERzYO4RgTi7NdkqBzbB6d30Vss2lO7' \
  --data-raw '{
      "dataSource": "production",
      "database": "sample_airbnb",
      "collection": "listingsAndReviews",
      "pipeline": [
        {
          "$search": {
            "index": "compund-test",
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
