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
