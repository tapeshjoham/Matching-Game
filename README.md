#Matching Game
Its a Matching based Game written in various languages like PHP, HTML/CSS with front-end checking using Javascript. In the Back-end ,Database is maintained by MySQL.

Project Members -

1) Amanshu Raikwar

2) Tapesh Joham

player side :-
[1] player can play game by arranging tiles containing image,vieo,audio or text

admin side :-
[1] basic function of admin ui is to add,delete,edit pairs(being done by tapesh) 
[2] there can be more than one admins
[3] admins can add pairs and they will be added in the pairs table with their corresponding username
[4] admins can be active or inactive , if an admin is active then his pairs will be included in the player's game and if inactive it will not be included
[5] there can be more than one active admins
[6] an admin can access only his/her pairs for editing , adding , deleting pairs

DATABASE SCHEMA :-(case sensitive)

[1]pairs
c1name varchar(200)
c1type varchar(10)
c2name varchar(200)
c2type varchar(10)
adminusername varchar(20)
id int

[2] playeraccount
username varchar(20)
password varchar(20)

[3] adminaccount
username varchar(20)
password varchar(20)
active boolean

[4]playerprofile
username varchar(20)
highscore int
gamesplayed int

[5]gamesplayed
date date
playerusername varchar(20)
score int

OUTPUTS :-
101 - username already taken , cant create account
102 - everything alright , move forward
103 - query is not running , returning 0 on running query
104 - invalid credentials while login
105 - error in table transactions , contact admin , invalid sql pass or un or dbname
106 - player current score is not greater than highscore
107 - player made a highscore

SUPPORTED FILE FORMATS :
image - jpg , jpeg , png , gif
video - mp4
audio - mp3 , wav , ogg

CONFIG FILE :- (assets/config.txt)
[1] sql_username
[2] sql_password
[3] sql_database
[4] pairs_no

LOCALHOST-PATH FILE :- (<everty directory>/path.txt) (present in every directory and sub-directory)
[1] localhost_path

SETTINGS :-
[1] sql username
[2] sql password
[3] sql database
[4] no of pairs shown to player
[5] active or not
