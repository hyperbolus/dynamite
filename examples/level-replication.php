<?php

// This script is meant for scanning the ID space of levels on the GD server and saving the info
// Tombstones are placed so that subsequent replication is faster

function msg($message): void
{
    echo date('H:i:s') . ' - ' . $message . ' - ' . PHP_EOL;
}

$db = new SQLite3('database.sqlite', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE);

$db->enableExceptions(true);

// Database Setup
$db->query(<<<'SQL'
CREATE TABLE IF NOT EXISTS 'responses' (
    'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'endpoint' VARCHAR,
    'query' VARCHAR,
    'response' VARCHAR,
    'reason' VARCHAR,
    'created_at' DATETIME
)

CREATE TABLE IF NOT EXISTS 'tombstones' (
    'level_id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'updated_at' DATETIME NOT NULL,
    'created_at' DATETIME NOT NULL,
)

CREATE TABLE IF NOT EXISTS 'levels' (
    'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'account_id' INTEGER,
    'player_id' VARCHAR,
    'downloaded' INTEGER,
    'last_fetched_at' DATETIME,
    'fetch_at' DATETIME,
    'time' DATETIME,
)

CREATE TABLE IF NOT EXISTS 'songs' (
    'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    
    'artist_id' INTEGER,
    'title' VARCHAR,
    
    'file_url' VARCHAR,
    'size' INTEGER,
    
    'scouted' INTEGER,
    
    'size' INTEGER,
    
    'created_at' DATETIME,
)

CREATE TABLE IF NOT EXISTS 'artists' (
    'id' INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    'name' INTEGER,
    'created_at' DATETIME,
)

CREATE TABLE IF NOT EXISTS 'users' (
    "id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    "user_id" INTEGER,
    "url" VARCHAR,
    "time" DATETIME
)

CREATE TABLE IF NOT EXISTS 'config' (
    'key' VARCHAR PRIMARY KEY NOT NULL,
    'value' VARCHAR,
    'type' VARCHAR,
)

INSERT OR IGNORE INTO 'config' NAME (key, value, type) VALUES ('schema', '1', 'int')
INSERT OR IGNORE INTO 'config' NAME (key, value, type) VALUES ('tombstone_threshold', '10000000', 'int')
SQL);

$db->close();