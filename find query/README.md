# Find Query Example
database: test collection: customers
filter by
```
{gender: "Male", region: {$gte: 627, $lte: 628}}
```

sort by
```
{firstname: 1}
```


### Group Query

##### Match Stage
{
  date: {
    $gte: new ISODate("2014-01-01"),
    $lt: new ISODate("2015-01-01"),
  },
}

#### Group Stage
{
  _id: {
    $dateToString: {
      format: "%Y-%m-%d",
      date: "$date",
    },
  },
  totalSaleAmount: {
    $sum: {
      $multiply: ["$price", "$quantity"],
    },
  },
  averageQuantity: {
    $avg: "$quantity",
  },
  count: {
    $sum: 1,
  },
}

#### Sort Stage
{
  totalSaleAmount: -1,
}
