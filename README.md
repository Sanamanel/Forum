# Welkom to the project Forum "Led-Zeppelin"

## The Project

joint project carried out in collaboration as part of the Hamilton 4.25 training at Becode November 2020.

the project was carried out by [Haddouch Rachida](https://github.com/Sanamanel), [Jansen Caroline](https://github.com/iCarolinei), [Mundher Ali](https://github.com/AliMundher), [Maillard Jonathan](https://github.com/JonathanMaillard), [Debroux Cédric](https://github.com/Cedricdebroux).



The project consists of the creation of a bulletin board created with HTML, CSS, Javascript, PHP, Bootstrap, MySQL ans SASS. 
The website is fully responsive and requires registration to access it.
In order to make it Dynamic, we have created a database.


## what did we do?

* Create a data base with four table :
  * Users
  * User_rate
  * Board
  * Topics
  * Message

![Data-base-shema](https://github.com/Sanamanel/Forum/blob/main/Readme/Data_base.png)

* Session variables
* register system and Login system 
* responsive design
* Profile pages(views and editing)
* Using gravatar or upload of an image for avatar of the user
* Create & edit Topic
* The author of a Topic can lock it 
* Post and reply to topic  by message
* Message can be edited by his author, and will show his edition date
* Users can only edit one of their Messages if it's the last of a Topic
* A Message can be deleted by his author, and will be shown as "deleted" in the Topic
* Markdown interpretation for content
* emojis supported
* Emoji library implemented
* Message reaction, the reaction is show at the end of each message, with the emoji and the amount of users who react with it and their username in a tooltip.
* Secret Board accessing with password
* We Create a Random Board, which can only have five topics in it - when creating the sixth, the oldest topic is deleted from the Board.
* Show the last 3 users online
* A search bar 
* Bloc aside with the 3 last topics  of the Forum
* Sticky menu with a back to the top button
* For the exercise the picture (avatar) were stored in a blog to the database.

To handle our local environment we used Lamp or Mamp and phpMyAdmin.

## Technologies We use for the development:
* html.
* css.
* php.
* mysql.
* sass.
* bootstrap.
* Javascript.

## Sécurity

Passwords have been encrypted with sha 512 for more security
For security we have used the heroku environment variables. 
All passwords still present in old commits have been modified .....

The spirit of our team is the fuel that allows us to attain  this result and we are very proud of it.
We were all involved in every aspect of this project. 
So,  let us introduce the Led Zeppelin forum: https://led-zepplin-forum.herokuapp.com/
