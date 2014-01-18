
Alter Table Character Add skype varchar(50)
Alter Table MEMB_INFO Add country varchar(50)
Alter Table Character Add BonusPoints bigint
Alter Table Character Add WeekTime bigint
CREATE TABLE Bank(
	AccountId char(10),
	Bank bigint
)
CREATE TABLE Stones(
	AccountId char(10),
	Stones bigint
)
CREATE TABLE Renas(
	AccountId char(10),
	Renas bigint
)
Create Table MaxPlayers(
	MaxPlayers int,
	Date varchar(50)
)
Create Table VoteLinks(
	ID int identity(1,1),
	Link varchar(150),
	img varchar(150),
	Prize varchar(50),
	Time bigint
)
Create Table Voted_Players(
	AccountId char(10),
	Link_Id int,
	Voted_Time bigint
)

/****** ToAddWeekOnlineTime ******/
USE [MuOnline]
GO
/****** Object:  StoredProcedure [dbo].[WZ_DISCONNECT_MEMB]    Script Date: 8.1.2014 ã. 19:14:05 ÷. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
ALTER PROCEDURE [dbo].[WZ_DISCONNECT_MEMB]
@memb___id varchar(10)
 AS
Begin    
set nocount on
    Declare  @find_id varchar(10)    
   Declare  @con_tm DATETIME
    Declare @ConnectStat tinyint
    Set @ConnectStat = 0     
    Set @find_id = 'NOT'
    select @find_id = S.memb___id, @con_tm = S.ConnectTM from MEMB_STAT S INNER JOIN MEMB_INFO I ON S.memb___id = I.memb___id COLLATE DATABASE_DEFAULT
           where I.memb___id = @memb___id
    if( @find_id <> 'NOT' )    
    begin        
        update MEMB_STAT set ConnectStat = @ConnectStat, DisConnectTM = getdate(), TotalTime = TotalTime+(DATEDIFF(mi,ConnectTM,getdate()))
         where memb___id = @memb___id
            -- TIMEONLINE MOD by john_d
   update character set WeekOnlineTime = WeekOnlineTime+(DATEDIFF(mi,@con_tm,getdate()))
   from character as c INNER join AccountCharacter as ac ON 
         c.Name = ac.GameIDC where c.accountid = @memb___id 
    end
end
/****** ToAddWeekOnlineTime END ******/