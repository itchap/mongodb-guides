<?php

require 'vendor/autoload.php';

use MongoDB\BSON\ObjectID;

// Connection URI
$uri = 'mongodb+srv://<username>:<password>@<cluster>.mongodb.net/test?retryWrites=true&w=majority';

// Database name
$dbName = 'mydatabase';

// Data to be inserted
$accommodations = [
    [
        '_id' => new ObjectID(),
        'listing_id' => 'A1001',
        'title' => 'Luxury Condo with Ocean View',
        'description' => 'This luxurious condo offers stunning ocean views and all the amenities you need for a comfortable stay.',
        'location' => [
            'address' => '123 Main St',
            'city' => 'Anytown',
            'state' => 'CA',
            'zip' => '12345',
            'country' => 'USA',
        ],
        'price' => 200,
        'amenities' => ['pool', 'gym', 'spa'],
        'availability' => [
            ['start' => '2023-06-01', 'end' => '2023-06-10'],
            ['start' => '2023-06-15', 'end' => '2023-06-20'],
        ],
        'rating' => 4.5,
    ],
    [
        '_id' => new ObjectID(),
        'listing_id' => 'A1002',
        'title' => 'Cozy Cabin in the Woods',
        'description' => 'Escape the city and enjoy the tranquility of this cozy cabin surrounded by trees and nature.',
        'location' => [
            'address' => '456 Elm St',
            'city' => 'Anytown',
            'state' => 'CA',
            'zip' => '12345',
            'country' => 'USA',
        ],
        'price' => 100,
        'amenities' => ['fireplace', 'bbq', 'hiking'],
        'availability' => [
            ['start' => '2023-07-01', 'end' => '2023-07-10'],
            ['start' => '2023-07-15', 'end' => '2023-07-20'],
        ],
        'rating' => 4.0,
    ],
    [
        '_id' => new ObjectID(),
        'listing_id' => 'A1003',
        'title' => 'Modern Apartment in the City',
        'description' => 'This modern apartment is located in the heart of the city and offers easy access to all the attractions and amenities.',
        'location' => [
            'address' => '789 Oak St',
            'city' => 'Anytown',
            'state' => 'CA',
            'zip' => '12345',
            'country' => 'USA',
        ],
        'price' => 150,
        'amenities' => ['wifi', 'parking', 'gym'],
        'availability' => [
            ['start' => '2023-08-01', 'end' => '2023-08-10'],
            ['start' => '2023-08-15', 'end' => '2023-08-20'],
        ],
        'rating' => 4.2,
    ],
];

// Create a new MongoDB client
$client = new MongoDB\Client($uri);

// Get a reference to the database
$database = $client->selectDatabase($dbName);

// Get a reference to the collection
$collection = $database->selectCollection('accommodations');

// Define the number of threads to use
$numThreads = 4;

// Split the data into batches
$batchSize = ceil(count($accommodations) / $numThreads);
$batches = array_chunk($accommodations, $batchSize);

// Create an array to hold the thread objects
$threads = [];

// Define a function to insert documents into the collection in a thread
function insertDocuments($collection, $batch) {
    $result = $collection->insertMany($batch);
    return $result->getInsertedIds();
}

// Create a thread for each batch of documents
foreach ($batches as $batch) {
    $thread = new Thread('insertDocuments', [$collection, $batch]);
    $thread->start();
    $threads[] = $thread;
}

// Wait for all threads to complete
foreach ($threads as $thread) {
    $thread->join();
}

// Print the IDs of the inserted documents
foreach ($threads as $index => $thread) {
    $insertedIds = $thread->getReturn();
    foreach ($insertedIds as $id) {
        echo "Inserted document with ID $id in thread $index\n";
    }
}