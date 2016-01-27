# Matching Game
Its a Matching based Game written in various languages like PHP, HTML/CSS with front-end checking using Javascript. In the Back-end ,Database is maintained by MySQL.

changed by amanshu

Project Member -

1) Amanshu Raikwar

2) Tapesh Joham

3) Ashish Arya

NOTE :
[1] go to assets/config.txt
[2] write your sqlun,sqlp, in the file instead of mine as i have written there
[3] check if mysqli commands run in your system, if not please run them, as they are new and old ones will soon be depricated
[4] dont change mysql commands to old one, its takes much work to change them back

player side :-
(being done by amanshu)

admin side :-
[1] basic function of admin ui is to add,delete,edit pairs(being done by tapesh) 
[2] there can be more than one admins
[3] admins can add pairs and they will be added in the pairs table with their corresponding username
[4] --
[5] admins can be active or inactive , if an admin is active then his pairs will be included in the player's game and if inactive it will not be included
[6] the superadmin will decide whether an admin is active or not
[7] the superadmin will also be responsible for making admin accounts
[8] there can be more than one active admins
[9] an admin can access only his/her pairs for editing , adding , deleting pairs

[10] (just a thought , not neccessary) as soon as an error occurs a messsage is sent to superadmin notifying of it 

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

CONFIG FILE :- (config.txt)
[1] sql_username
[2] sql_password
[3] sql_database 

LOCALHOST-PATH FILE :- (path.txt) (present in every directory and sub-directory)
[1] localhost_path

SETTINGS :-
[1] sql username
[2] sql password
[3] sql database
[4] localhost path
[5] no of pairs shown to player
[6] 