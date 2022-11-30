# Search Examples

### Compound Search

##### index

{
  "mappings": {
    "fields": {
      "address": {
        "fields": {
          "country": {
            "analyzer": "lucene.standard",
            "type": "string"
          },
          "location": {
            "type": "geo"
          },
          "market": [
            {
              "foldDiacritics": false,
              "maxGrams": 2,
              "minGrams": 1,
              "tokenization": "edgeGram",
              "type": "autocomplete"
            },
            {
              "analyzer": "lucene.standard",
              "type": "string"
            }
          ]
        },
        "type": "document"
      },
      "cancellation_policy": {
        "analyzer": "lucene.standard",
        "type": "string"
      },
      "description": {
        "analyzer": "lucene.standard",
        "type": "string"
      },
      "location": {
        "analyzer": "lucene.standard",
        "type": "string"
      },
      "name": [
        {
          "foldDiacritics": true,
          "maxGrams": 10,
          "minGrams": 2,
          "tokenization": "edgeGram",
          "type": "autocomplete"
        }
      ]
    }
  }
}

##### Basic Search Query
[
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
      'score': { "$meta": 'searchScore' },
    }
  }
]

##### Compound Query
[
  {
    "$search": {
      "index": "compund-test",
      "compound": {
          "must": [{
            "text": {
              "query": 'pool',
              "path": 'description'
            }
          }],
          "mustNot": [{
            "text": {
              "query": 'United States',
              "path": 'address.country'
            }
          }]
        }
      }
  },
  {
    "$project": {
      "_id" : 0,
      "name": 1,
      "description": 1,
      "address.country":1,
      'score': {
        "$meta": 'searchScore'
      }
    }
  }
]

##### Score Boosting Query
[
  {
    "$search": {
      "index": "compund-test",
      "compound": {
        "must": [{
          "text": {
            "query": 'pool',
            "path": 'description'
          }
        }],
        "should": [{
          "text": {
            "query": 'wifi',
            "path": 'description',
            "score": { "boost": { "value": 10 } }
          }
        }]
      }
    }
  },
  {
    "$project": {
      "_id" : 0,
      "name": 1,
      "description": 1,
      'score': {
        "$meta": 'searchScore'
      }
    }
  }
]


##### Fuzzy Matching Query
[  
  {
    "$search": {
      "index": "compund-test",
      "text": {
        "path": "description",
        "query": "basball",
        "fuzzy": { "maxEdits": 1, "prefixLength": 2 }
      }
    }
  },
  {
    "$project": {
      "_id" : 0,
      "name": 1,
      "description": 1,
      'score': { "$meta": 'searchScore' },
    }
  }
]


##### Phrase & Slop Query
[  
  {
    "$search": {
      "index": "compund-test",
      "phrase": {
        "path": "description",
        "query": "spacious comfortable",
        "slop": 2
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
      'score': { "$meta": 'searchScore' },
    }
  }
]


##### Complex Search with Geo location
[  
  {
    "$search": {
      "index": "compund-test",
      "compound": {
        "must": [
          {
            "text": {
              "query": "pool",
              "path": "description"
            },
          },
          {
            "text": {
              "query": "US",
              "path": "location"
            },
          },
          {
            "geoWithin": {
              "circle": {
                "center": {
                  "type": "Point",
                  "coordinates": [-74.00714, 40.71455]
                },
                "radius": 2000
              },
              "path": "address.location"
            }
          },
        ],
        "should": {
          "search": {
            "path": "description",
            "query": "garden"
          }
        },
        "mustNot": {
          "search": {
            "path": "cancellation_policy",
            "query": "strict",
            "phrase": {"prefix": True}
          }
        }                
      }
    }
  },
  {
    "$project": {
      "name": 1,
      "description": 1,
      "cancellation_policy": 1,
      "accommodates": 1,
      "bedrooms": 1,
      "bath": 1,
      "price": 1,
      "images.picture_url": 1,
      "address.location": 1
    }
  }
]


##### Highlight Search Results query
[  
  {
    "$search": {
      "index": "compund-test",
      "text": {
        "path": "description",
        "query": "pools",
        "fuzzy": { "maxEdits": 1, "prefixLength": 2 }
      },
      'highlight': { "path": "description" }        
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
      'highlights': {"$meta": "searchHighlights"},
      'score': { "$meta": 'searchScore' },
    }
  }
]
