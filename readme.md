# l5CalendarApiServer
Demo  of test API build with laravel 5 

Available API request 
All method for CRUD available on this URL's  
 - server.com/categories
 - server.com/statuses
 - server.com/tasks
 - server.com/events
 - server.com/colors

Availabe GET method on this URl
server.com/search 

with parameter 
 - type [All , task , event]
 - start_at - date format YYYY-MM-DD
 - end_at - date format YYYY-MM-DD
 - search - string - used for search on Event/Task title column 
  

#Installation 
 - Clone this git ;
 - Run Composer install ; ([sudo] composer install)
 - Change ENV, database variables ;
 - Run migration; ([sudo] php artisan migrate) 
 - Run Seed; ([sudo] php artisan db:seed)

# Test API 

Use POSTMAN or some addition tools to test API 

 

