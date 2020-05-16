<?php

$connect = new PDO("mysql:host=localhost", "root", "");

$sql = "CREATE DATABASE DATABASE_TEST;

CREATE TABLE DATABASE_TEST.tbl_users (
    id int AUTO_INCREMENT PRIMARY KEY,
    name varchar(50),
    email varchar(50),
    location varchar(255),
    bio varchar(255),
    about varchar(255),
    relationship_status varchar(50),
    occupation varchar(50),
    hometown varchar(50),
    alma_mater varchar(50),
    hero varchar(50),
    hero_quote varchar(255),
    hero_pic varchar(255),
    profile varchar(255),
    cover varchar(255),
    phone varchar(14),
    carrier varchar(50),
	password varchar(255),
    privacy tinyint,
    two_factor_auth tinyint,
	two_factor_token varchar(6),
    two_factor_expiry timestamp,
    ip varchar(255),
    returning_user tinyint,
    last_login timestamp DEFAULT CURRENT_TIMESTAMP,
    created_on timestamp DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE DATABASE_TEST.tbl_posts (
    post_id int AUTO_INCREMENT PRIMARY KEY,
    parent_post_id int,
    post varchar(50),
    image varchar(255),
    post_creator_id varchar(255),
    ip varchar(255),
    date timestamp DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE DATABASE_TEST.chat_message (
    chat_message_id int AUTO_INCREMENT PRIMARY KEY,
    to_user_id int,
    from_user_id int,
    chat_message varchar(255),
    ip varchar(255),
    timestamp timestamp DEFAULT CURRENT_TIMESTAMP,
    status int
    );

    CREATE TABLE DATABASE_TEST.login_details (
    login_details_id int AUTO_INCREMENT PRIMARY KEY,
    user_id int,
    last_activity timestamp DEFAULT CURRENT_TIMESTAMP,
    is_type ENUM('no', 'yes')
    );";

$statement = $connect->prepare($sql);

if ($statement->execute()) {
    echo "Database created successfully!";
} else {
    echo "Error! Database was not created successfully. Please check the syntax.";
}
