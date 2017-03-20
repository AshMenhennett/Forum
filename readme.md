# Elite Forum

This is a repository for a fully-fledged modern forum app, including private messaging, built with Laravel 5.3 and Vue 2.

## Highlights
- @mention functionality, alerting ```User```s by email when they are mentioned in a post. Including auto link generation, when a ```User``` uses the @mention functionality. I.e ```@ashmenhennett``` will be converted to ```[@ashmenhennett](http://example.com/user/profile/@ashmenhennett)```.
- Internal user messaging system, in realtime, using  ```pusher-js``` and ```Laravl-Echo```.
- User role system, including Administrators (```admin```),  Moderators (```moderator```) and standard Users (```user```).
- Ability for Administrators to invite new users, with a specific role, as well as the ability to modify current ```User```'s roles.
- Ability for users to subscribe to ```Topic```s.
- Ability for users to 'report' ```Post```s and ```Topic```s.
- Avatar image uploading to Amazon S3 storage.
- Markdown support for creating posts. *All posts are stored in database as Markdown and are converted to HTML, when needed*

## Functionality
- ```User```s can register and create ```Topic```s and ```Post```s.
- ```User```s may subscribe to any ```Topic```s and may report any ```Topic``` or ```Post``` for moderation.
- Users can @mention other users in ```Post```s.
- Users can send and receive messages from other users in realtime, via the internal messaging system.
- Owners of ```Post```s or eleveated ```User```s may modify or delete ```Post```s.
- Only ```admin``` and ```moderator``` accounts may delete ```Topic```s.
- Users can manage their own profile changing to their password and avatar image.
- All subscribed ```User```s recieve emails, via a triggered event when a ```Topic``` that they are subscribed to has a ```Post``` added to it.
- Moderators are alerted via email when content is reported. Moderators can easily manage these reports in the Moderator Dashboard.
- Other expected events are raised, check out ```App\Events``` and ```App\Listeners``` for further insight. See ```App\Providers\EventServiceProvider```'s ```$listen``` property for the association of ```Event```s and ```Listener```s.

## Installation & Configuration
If you would like to install this project, treat it as you would any other Laravel application:
- Clone the repo.
- Install dependencies: ```composer install``` (also, ```npm install```, if you need).
- Configure environment variables- ```.env``` (see below).
- Generate application key: ```php artisan key:generate```.
- Run Laravel migrations: ```php artisan migrate```.

Make sure you configure these environment variables:
- ```APP_URL``` : the url of the application. This variable is used for linking to the application in emails.
- ```APP_NAME```: the human readable name of the application. This variable is used for refering to the application via emails. It is also used in the navbar as the application branding.
- ```MAIL_FROM_EMAIL``` and ```MAIL_FROM_NAME```: the 'from' email address and name. This is used for sending out emails.
- ```S3_KEY```, ```S3_SECRET```, ```S3_REGION```, ```S3_BUCKET_NAME``` and ```S3_IMG_BUCKET_URL```: the conncetion to Amazon S3 variables. These values are used for the avatar uploading facility built in to the application.
- ```PUSHER_APP_ID```, ```PUSHER_KEY``` and ```PUSHER_SECRET```: the connection configuration for the ```pusher``` broadcast driver.

Further steps:
- Set the ```QUEUE_DRIVER``` environment variable to ```database```.
- Set the ```BROADCAST_DRIVER``` environment variable to the broadcast driver to be used. Set this to ```pusher``` if you wish to use the pusher API with ```Laravel Echo```.
- Set the ```APP_ENV``` environment variable to ```production``` when the app is on a live sever, to force HTTPS connections on all routes.
- Configure your Amazon S3 bucket with a policy that will allow the application to upload avatars to it.
- Configure the ```Laravel Echo``` instance in ```resources/assets/js/bootstrap.js```, starting line 41.
- Run ```php artisan queue:work``` to allow jobs, queued mail and event broadcasting to function.

## Commands
There are a couple of commands for use with this application:
- When the 'to-be' Administrator registers for an account, it is necessary to execute the ```alter:role``` command via command line, after they have registered, passing in the id of the ```User``` and the role (i.e. ```admin```). Eg. ```php artisan alter:role 1 admin```. This is currently the only logical way of elevating a specific user, when no other ```admin```s exist.
- The local storage of avatars will have to be cleaned every now and then. To do so, execute the following command ```php artisan clear:avatars```. They exist in the application storage, as they are uploaded to the applications storage, before being uploaded to Amazon's S3. *They are currently not being automatically deleted from local storage after uploading to S3*.

## Screenshots
### Admin Dashboard
![Administrator dashboard- top](https://cloud.githubusercontent.com/assets/9494635/20865189/631adf40-ba5b-11e6-9ea1-7fc614a45f28.PNG)
![Administrator dashboard- bottom](https://cloud.githubusercontent.com/assets/9494635/20865186/631a3d74-ba5b-11e6-85aa-4a3e53656a6d.PNG)

### Topics
Creating a Topic
![Creating a Topic](https://cloud.githubusercontent.com/assets/9494635/20865190/631bc072-ba5b-11e6-9624-0d555d6c0456.PNG)

My Topics
![My Topics](https://cloud.githubusercontent.com/assets/9494635/20865195/634b6b7e-ba5b-11e6-97bc-e2255c65fe64.PNG)

All Topics
![All Topics](https://cloud.githubusercontent.com/assets/9494635/20865187/631a3f4a-ba5b-11e6-9c01-7d8a9594193b.PNG)

Single Topic
![Topic- top](https://cloud.githubusercontent.com/assets/9494635/20865196/634e1ea0-ba5b-11e6-8435-d6b6ceecde13.PNG)
![Topic- bottom](https://cloud.githubusercontent.com/assets/9494635/20865194/634b39b0-ba5b-11e6-95e6-516666b1aedb.PNG)

### Moderator Dashboard
![Moderator Dashboard](https://cloud.githubusercontent.com/assets/9494635/20865192/63494b1e-ba5b-11e6-8a1d-73d0fead965f.PNG)

### User Profile
User profile view
![User Profile](https://cloud.githubusercontent.com/assets/9494635/20865193/634b08b4-ba5b-11e6-8898-b70b85b33934.PNG)

Editing a profile
![Edit Profile](https://cloud.githubusercontent.com/assets/9494635/20865191/631bde9a-ba5b-11e6-9a68-b4d337ae4c0a.PNG)

### User Messaging
Threads
![Conversations or Threads](https://cloud.githubusercontent.com/assets/9494635/21446200/0355f88a-c913-11e6-8875-23f3f1b37692.PNG)

Messaging
![Messaging System](https://cloud.githubusercontent.com/assets/9494635/21446174/b0f4d94e-c912-11e6-8f8f-58c282143408.PNG)

## Routes
![Routes](https://cloud.githubusercontent.com/assets/9494635/21446273/ff2ef4f4-c913-11e6-9546-50b476098e2a.PNG)
Thanks to [Pretty Routes](https://github.com/garygreen/pretty-routes)

## Additional Packages
- [AWS SDK PHP](https://github.com/aws/aws-sdk-php)
- [Carbon](https://github.com/briannesbitt/carbon)
- [Flysystem AWS S3](https://github.com/thephpleague/flysystem-aws-s3-v3)
- [Image](https://github.com/Intervention/image)
- [Laravel Markdown](https://github.com/GrahamCampbell/Laravel-Markdown)

## Additional Modules
- [Laravel Echo](https://github.com/laravel/echo)
- [Pusher](https://github.com/pusher/pusher-js)

## License
[MIT](https://s3-ap-southeast-2.amazonaws.com/ashleymenhennett/LICENSE)

