<p align="center">
    <h1 align="center">Tourhunter test task</h1>
    <br>
</p>

Task was implemented using [layered structure](https://www.toptal.com/php/maintain-slim-php-mvc-frameworks-with-a-layered-structure)  
I can also do this task without services and repositories, if needed.    
  
[Task site](http://ec2-52-14-147-81.us-east-2.compute.amazonaws.com)

Setup guide
-----------

**Run these commands:**  
`composer install`
`php yii migrate`  

**Task**  
The user can only use a unique nickname without a password for authorization / registration. If there is no such user, then create it automatically and authorize. There should be a public page with a list of all users and their current balance, available without authorization.

For authorized users available:

The user can transfer any positive amount to another user (identification by nickname). In this case, the user's balance is reduced by the specified amount. The balance may be negative. Balance can not be less than -1000. The balance of all new users defaults to 0. You can transfer any amount (with two decimal places for cents) to any nickname, even a fictional, if such a nickname does not exist in the database, then we create such a user automatically and credit the transfer amount to it. The user can not do the translation itself.

Users can see all transfers related to their balance in their office as a transfer history.

Use yii2 (latest stable version, basic project template). Installing database from migrations, installing external plugins from composer with minimal stable stability. Code design in accordance with the coding style and directory structure in yii2. The code should not have bugs, security holes, violations of the planned service logic. For speed development, use crud to create / edit / delete objects, as well as other features of yii2. The code must be professional, supported, and understandable. All necessary unit codeception tests should be written.
