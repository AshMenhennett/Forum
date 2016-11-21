# Forum

This is a repository for a simple Forum app that I created while learning Laravel and Vue.

Feel free to take a look around the codebase.

## Installation & Configuration
If you would like to install this project, treat it as you would any other Laravel application, keeping in mind some additional crucial environment variables:
- ```APP_URL``` : the url of the application. This variable is used for linking to the application in emails.
- ```APP_NAME```: the human readable name of the application. This variable is used for refering to the application via emails. It is also used in the navbar as the application branding.
- ```MAIL_FROM_EMAIL``` and ```MAIL_FROM_NAME```: the 'from' email address and name. This is used for sending out emails.
- ```S3_KEY```, ```S3_SECRET```, ```S3_REGION```, ```S3_BUCKET_NAME``` and ```S3_IMG_BUCKET_URL``: the conncetion to Amazon S3 variables. These values are used for the avatar uploading facility built in to the application.

Further steps:
- Make sure you set the ```QUEUE_DRIVER``` environment variable to ```database```.
- Set the ```APP_ENV``` environment variable to ```production``` when the app is on a live sever, to force HTTPS connections on all routes.
- Make sure that you configure your Amazon S3 bucket with a policy that will allow the application to upload avatars to it.
