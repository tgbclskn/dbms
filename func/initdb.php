<?php

function initdb()
{
		$db = new SQLite3('../db.sqlite');
		
		foreach ([
		
		//User table
		'CREATE TABLE "Users" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"name" VARCHAR UNIQUE NOT NULL,
			"password" VARCHAR NOT NULL,
			"location" VARCHAR,
			"about" VARCHAR,
			"picture" VARCHAR
		)',
		
		//Gig table
		'CREATE TABLE "Gigs" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"ownerid" INTEGER NOT NULL,
			"description" VARCHAR,
			"categoryid" INTEGER NOT NULL,
			"price" VARCHAR NOT NULL,
			FOREIGN KEY(ownerid) REFERENCES User(id)
			FOREIGN KEY(categoryid) REFERENCES Categories(id)
		)', 
		
		//Order table
		'CREATE TABLE "Orders" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"gigid" INTEGER NOT NULL,
			"sellerid" INTEGER NOT NULL,
			"buyerid" INTEGER NOT NULL,
			"startdate" VARCHAR,
			"enddate" VARCHAR,
			"payment" VARCHAR,
			"isactive" INTEGER,
			"file" VARCHAR,
			"completeddate" VARCHAR,
			FOREIGN KEY(gigid) REFERENCES Gig(id),
			FOREIGN KEY(sellerid) REFERENCES User(id),
			FOREIGN KEY(buyerid) REFERENCES User(id)
		)',
		
		//Message table
		'CREATE TABLE "Messages" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"senderid" INTEGER NOT NULL,
			"receiverid" INTEGER NOT NULL,
			"text" INTEGER NOT NULL,
			"date" VARCHAR,
			FOREIGN KEY(senderid) REFERENCES User(id),
			FOREIGN KEY(receiverid) REFERENCES User(id)
		)',
		
		//Review table
		'CREATE TABLE "Reviews" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"raterid" INTEGER NOT NULL,
			"ratedid" INTEGER NOT NULL,
			"rating" INTEGER NOT NULL,
			"comment" VARCHAR,
			FOREIGN KEY(raterid) REFERENCES User(id),
			FOREIGN KEY(ratedid) REFERENCES User(id)
		)',
		
		//Category table
		'CREATE TABLE "Categories" (
			"id" INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
			"name" VARCHAR NOT NULL
		)',
		
		//Moderator table
		'CREATE TABLE "Moderators" (
			"userid" INTEGER NOT NULL
		)'
		
		] as $query)
		
		{
			$db->query($query);
		}
		
		$db->close();
		
}

?>
