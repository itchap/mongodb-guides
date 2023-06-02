from pymongo import MongoClient
import pandas as pd
from pyspark.sql import SparkSession
from pyspark.sql.types import (
    StringType, StructType, StructField, BooleanType,
    IntegerType, ArrayType, TimestampType, MapType,
)

# Connect to MongoDB
client = MongoClient('mongodb+srv://<username>:<password>@<atlas-hostname>/?retryWrites=true&w=majority')
db = client['sample_analytics']
collection = db['customers']

# Retrieve data from MongoDB into a Pandas DataFrame
df = pd.DataFrame(list(collection.find()))

# Convert ObjectId to string in the Pandas DataFrame
df['_id'] = df['_id'].astype(str)

# Handle nan values by converting them to None
df = df.where((pd.notnull(df)), None)

# Define the schema for the PySpark DataFrame
schema = StructType([
    StructField("_id", StringType(), True),
    StructField("username", StringType(), True),
    StructField("name", StringType(), True),
    StructField("address", StringType(), True),
    StructField("birthdate", TimestampType(), True),
    StructField("email", StringType(), True),
    StructField("active", BooleanType(), True),
    StructField("accounts", ArrayType(IntegerType()), True),
    StructField("tier_and_details", MapType(StringType(), StructType([
        StructField("tier", StringType(), True),
        StructField("id", StringType(), True),
        StructField("active", BooleanType(), True),
        StructField("benefits", ArrayType(StringType()), True),
    ])), True),
])

# Convert the Pandas DataFrame to a PySpark DataFrame with the defined schema
spark = SparkSession.builder.getOrCreate()
spark_df = spark.createDataFrame(df, schema=schema)

# Define the path to save the Parquet file
parquet_path = './customers.parquet'

# Save the PySpark DataFrame as a Parquet file
spark_df.write.parquet(parquet_path)
