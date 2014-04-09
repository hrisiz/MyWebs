CREATE TRIGGER OnMoveAFKPrize
ON Character
AFTER UPDATE
AS 
	DECLARE @account char(10)
	DECLARE @character char(10)
	DECLARE @x int
	DECLARE @y int
	DECLARE @map int
	DECLARE @last_map int
	DECLARE @last_x int
	DECLARE @last_y int

	SET @account = (SELECT AccountID FROM inserted)
	SET @character = (SELECT Name FROM inserted)
	SET @x = (SELECT MapPosX FROM inserted)
	SET @y = (SELECT MapPosY FROM inserted)
	SET @map = (SELECT MapNumber FROM inserted)
	Set @last_x = (Select PosX From AFKCharacters Where AccountId=@account)
	Set @last_y = (Select PosY From AFKCharacters Where AccountId=@account)
	Set @last_map = (Select Map From AFKCharacters Where AccountId=@account)

	IF((@last_map IS NULL AND (@map = 0 OR @map = 2 OR @map = 3)) OR @last_x != @x OR @last_y != @y OR @last_map != @map)
	BEGIN
		EXEC GiveAFKPrize @account
		Set @last_map = (Select Map From AFKCharacters Where AccountId=@account)
		IF (((Select Count(*) From MEMB_STAT Where memb___id=@account AND ConnectStat=1) > 0) AND (@map = 0 OR @map = 2 OR @map = 3) )
		BEGIN
			Insert Into AFKCharacters values(@account,@map,GETDATE(),@x,@y)
		END
	END
GO



USE [MuOnline]
GO
/****** Object:  StoredProcedure [dbo].[GiveAFKPrize]    Script Date: 8.4.2014 г. 21:42:54 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[GiveAFKPrize](@account char(10))
AS 
BEGIN
	Declare @last_map datetime
	Set @last_map = (Select Map From AFKCharacters Where AccountId=@account)
	IF(@last_map IS NOT NULL)
	BEGIN
		Declare @last_date datetime
		Declare @hey1 bigint
		Declare @hey2 bigint
		Declare @hey bigint
		Set @last_date = (Select Time From AFKCharacters Where AccountId=@account)
		Declare @Date datetime  = GETDATE()
		Set @hey1 = CONVERT(VARCHAR(30),  GETDATE(), 112) + REPLACE(CONVERT(VARCHAR(30),  GETDATE(), 108), ':', '')
		Set @hey2 = CONVERT(VARCHAR(30), @last_date, 112) + REPLACE(CONVERT(VARCHAR(30), @last_date, 108), ':', '')
		Set @hey = (@hey1 - @hey2)/100 - 40
		if (@hey > 1)
		BEGIN
			if (@last_map = 0)
			BEGIN
				Update Renas Set Renas=Renas+(@hey) Where AccountId=@account
			END
			else if (@last_map = 3)
			BEGIN
				Update Stones Set Stones=Stones+(@hey) Where AccountId=@account
			END	
			else if (@last_map = 2)
			BEGIN
				Update Bank Set Bank=Bank+((@hey/30)*2500000) Where AccountId=@account
			END	
		END
		Delete From AFKCharacters Where AccountId=@account
	END
END
