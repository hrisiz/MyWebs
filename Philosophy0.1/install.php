<?
	$web['dbhost'] = 'xBeast-PC';
	$web['dbuser'] = 'sa';
	$web['dbpassword'] = 'Psihopat1';
	$dbc = mssql_connect($web['dbhost'], $web['dbuser'], $web['dbpassword']) or die("Couldn't connect to SQL Server!"); 
	mssql_query("
	CREATE DATABASE Questions
	");
	mssql_query("
	use Questions
	CREATE TABLE Questions(
		ID int identity(1,1),
		Question varchar(200),
		Answer_1 varchar(50),
		Answer_2 varchar(50),
		Answer_3 varchar(50),
		Answer_4 varchar(50),
		Correct_Answer int,
		Question_Points int
	)
	CREATE TABLE Users(
		ID int identity(1,1),
		User_Name char(10),
		Password varbinary(100),
		MaxPoints int
	)
	CREATE TABLE Test(
		ID int,
		User_Name char(10),
		Questions bigint,
		Answers varbinary(102)
	)
	Alter Table Users Add EndedTime bigint
	");
?>