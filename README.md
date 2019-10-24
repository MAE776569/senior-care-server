# Senior Care Server

Senior care is an IOT system that consists of a wearable belt which contains a small hardware device that helps the seniors in their everyday life in case of emergency such as falling or needing any help.

## How to start the server

- install all project dependencies with `composer install`
- make sure to install passport with `php artisan passport:install`
- migrate the database with `php artisan migrate`
- start the development server with `php artisan serve`

Before you start the server make sure to start the **database server**

## Project elements

The project consits of three main parts:

1. Hardware device
2. Server and database
3. Mobile app

### Hardware

The hardware consists of three parts:

1. Fall detection sensor
2. Push button
3. WiFi module

### The server

The server provides the REST API to the mobile application to be able to get the data and interact with it and also connected directly with the mobile app through socket service.

Once one of three action is triggerd (fall detected, button pressed or calling for help), the hardware wil send the data directly to the server and the server will send live notification to the mobile app.

### The mobile application

The application shows the data related to the senior plus the history of the triggered actions using the device, It also shows the location of the senior when a notification is received.
