basic structure of the project :
three parts :
[1]login
[2]player
[3]admin

populating database:
match the following , column element types:
[1]text
[2]image
[3]audio
[4]video

database name: matchthefollowinggame

database schema
[1]adminaccount
[2]playeraccount
[3]pairs

relation definition of pairs
[1]c1name varchar(200) not null		<path of file>
[2]c1type varchar(10) not null		<text/audio/video/image>
[3]c2name varchar(200) not null		<path of file>
[4]c2type varchar(10) not null		<text/audio/video/image>

t-text
a-audio
v-video
i-image

relation definition of adminaccount and playeraccount
[1]username varchar(20) not null
[2]password varchar(20) not null