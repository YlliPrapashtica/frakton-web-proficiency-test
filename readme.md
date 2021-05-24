# Frakton Web Proficiency Test

A few API Endpoints

## Getting Started

 1. First things first, Create a Database Named frakton_web, locally hosted, in order for the config to autoconnect. 
## $db_user = "root";
## $db_password ="";
## $db_name = 'frakton_web';

 2. Run the /includes/createDatabase.php script to create tables + sample table values.

 ## 1. Provide an API Endpoint that allows a user to register to the system. The user should provide the first name, last name, email and password. No email confirmation needed.
 
 1. Run POST Method to the url : localhost/web/api/createUser.php (if hosted locally);
 2. Provide data in JSON in the body, such as the following Sample Data below :
 ### Sample JSON Data 
 #### {
 ####   "first_name": "Ylli",
 ####   "last_name": "Prapashtica",
 ####   "email": "yllip.99@gmail.com",
 ####   "password": "YlliPassword"
#### }

## 2. Provide an API Endpoint that allows the user to authenticate to the system.

1. Run GET Method to the url : localhost/web/api/authenticate.php (if hosted locally);
2. Inlcude an Authorization of the type : Basic Auth;
3. Provide 'Email' in the 'Username' field;
4. If the user already has an account created, it will become authorized so the user no longer needs to re-authorize.

## 3. Provide an API Endpoint that returns a list of crypto coins. This endpoint should be accessible only from authenticated users. The crypto coins should be fetched from a third microservice: https://api.coincap.io/v2/assets. Provide only these fields of coins in the response: id, rank, symbol, name, supply, maxSupply.

1. Run GET Method to the url : localhost/web/api/printCryptoCoins.php (if hosted locally);
2. Inlcude an Authorization of the type : Basic Auth;
3. Provide 'Email' in the 'Username' field;
4. Checks if user is authorized,if so, the Crypto Coin list will be printed as JSON with the requested data.

## 4. Provide an API Endpoint for authenticated users that allows them to mark & unmark a specific coin as/from favorite.


1. Run POST Method to the url : localhost/web/api/manageFavoriteCoins.php (if hosted locally);
2. Inlcude an Authorization of the type : Basic Auth;
3. Provide 'Email' in the 'Username' field;
4. Provide data in JSON in the body, such as the following Sample Data below :
### Sample Remove From Favorite JSON Data Required
 #### {
 ####    "coinID": "ethereum",
 ####   "mode":"remove
#### }

### Sample Add To Favorite JSON Data Required
 #### {
 ####    "coinID": "ethereum",
 ####   "mode":"add"
#### }


## 5. Provide an API Endpoint that returns only the favorite coins for the authenticated user.

1. Run GET Method to the url : localhost/web/api/showFavoriteCoins.php (if hosted locally);
2. Inlcude an Authorization of the type : Basic Auth;
3. Provide 'Email' in the 'Username' field;
4. Checks if user is authorized,if so, the Favorite Crypto Coin list will be printed as JSON.
