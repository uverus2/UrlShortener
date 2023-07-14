# Url Shortener 

## Installation

The project is using the Laravel Sail installation which includes the Laravel application and only a redis DB. 

### App installation

To install the project please follow the steps below:
- Step 1 - ```cd url-shortener```
- Step 2 - Create an ENV file using the data within the .env.example
- Step 3 - ```./vendor/bin/sail build && ./vendor/bin/sail up```
- Step 4 - ```./vendor/bin/sail composer install ```
- Step 5 - The project should now be installed, and it can be opened on your localhost 
  - It is mapped to port 80, so you can use the following (url)[http://localhost/];

## Postman Set Up

Please find the Postman Collection of all the endpoint available on the application within the root folder of the Repo. The file is called "Postman URL Shortener Collection"
Import the collection into postman to see all the available endpoints within the application. 

## Endpoint Map

| Postman Name       | Type | Url                                            | Purpose                                                                                                                                                                                                                                                                                                                                                                                                                      |   |
|--------------------|------|------------------------------------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---|
| URL Encode         | POST | http://localhost/api/v1/url/encode             | You are required to pass a valid URL. The endpoint is used to encode the URL you have passed. You will receive a JSON response with the original URL, unique code and short url.  Validation will ensure URL is valid and it is present. Validation errors will return with 422.  Other errors will default to 500 no appropriate code is passed.                                                                            |   |
| URL Decode By URL  | POST | http://localhost/api/v1/url/decode             | You are required to pass a valid URL. The URL you supply should be the one received by "URL Encode". You will receive "original_url" key with the value of the URL you encoded previously.  If the URL is not found you will receive a 404 response back from the server. Validation errors will return with 422.  Other errors will default to 500 no appropriate code is passed.                                           |   |
| URL Redirect       | POST | http://localhost/api/v1/url/decode/redirect    | You are required to pass a valid URL. The URL you supply should be the one received by "URL Encode". You will be redirected to the website the encoding URL matches.  If the URL is not found you will receive a 404 response back from the server. Validation errors will return with 422.  Other errors will default to 500 no appropriate code is passed.                                                                 |   |
| URL Decode By Code | GET  | http://localhost/api/v1/url/decode/code/{code} | You are required to pass a valid URL. You are required to pass a dynamic {code} within the URL. The code will be the one you receive from the "URL Encode" endpoint under "unique_code" You will receive "original_url" key with the value of the URL you encoded previously.  If the URL is not found you will receive a 404 response back from the server. Other errors will default to 500 no appropriate code is passed. |   |

## Justifications

The endpoints are split from the app.php in the routes folder to allow for versioning and separation into further files for easier navigation. 
Once the file starts to grow with different functionalities we can easily abstract them into different files within the routes/api folder.

Once controller was used to contain the 4 endpoints which uses a few dependencies that will be listed below. 

Each of the POST request contain the same URL validation Form Request Validation file to minimize code repetition. 

The controller uses the GeneralTrait Trait which contains a function to check if we have a stored decoded URL based on the value the user has provided.
The Trait can be renamed to something different in the future if the file grows. 
I believe it was best to abstract that repeated logic in a location we can utilise in other controllers/classes if required.

The error handling is handled via a service which takes an exception. It is simple error handling resulting in a JSON response. 
Simple checking ensures we provide valid error status/message or default to 500 in case it is other application error. 
Validation and Type errors are handled separately within the Exception/Handler. 
The idea behind the class if in the future we decide to change the format of our errors or handle specific type of errors we will handle them in one place. 
We will not have to go to all controllers and change everything in case a change is required. 

To handle the storage and URL shortening/encoding we use the URlHandlerService. The logic is in one place, and it can be reused in the future if required. 
We can further change the logic if we require. The service itself uses 2 different strategy patterns where on is for storing and the other for encoding/decoding the URl.

The encoding/decoding strategy implements the UrlShortenStrategyContract to ensure all strategy follow the same rules. We are required to have 2 public functions.
The one strategy we have in place is the HashShortUrlLibrary which uses md5 hashing algorithm to hash the original URL. We then take the first 6 characters of the hash to produce a unique code.
The unique code is used to create the new shorten URL. The URL prefix and the length of how much we split by is stored in ENUM file to ensure a simple change from one place which might be unnecessary for the current implementation, but I have decided to leave it.
The encoding logic will produce the new URL, old URL and a unique code which will be used as a storage key within our Cache.
I have implemented a strategy pattern here to ensure if we wish to change the encoding/decoding we can easily ensure future logic will adhere to certain rules.
The class is bind to the app in the app service provider to ensure laravel can resolve the dependency when we inject the interface within the service.

The storage class is a simpler strategy pattern and its responsibility is to ensure we can easily store and retrieve our encoded information somewhere.
We are always required to pass the same data and access the same methods, but we do not care where the information is stored which is why I have used the pattern. 
The CacheStorageStrategy class is concretely bound to the app again with the abstraction being StorageStrategyContract, so laravel knows how to handle this. 

## Naming Convention 

Services - Will end with "Service"
Interfaces - Will end with "Contract"
Pattern Classes - Will end with the pattern they implement for example "Strategy"
Enums - Will end with "Enums"
Controller - Will end with "Controller"
Traits - Will end with "Trait"

