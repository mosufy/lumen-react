# Lumen - API

[![Build Status](https://travis-ci.org/mosufy/lumen-api.svg?branch=master)](https://travis-ci.org/mosufy/lumen-api) 
[![codecov](https://codecov.io/gh/mosufy/lumen-api/branch/master/graph/badge.svg)](https://codecov.io/gh/mosufy/lumen-api)
[![GitHub release](https://img.shields.io/github/release/mosufy/lumen-api.svg?maxAge=2592000)](https://github.com/mosufy/lumen-api)
[![GitHub tag](https://img.shields.io/github/tag/mosufy/lumen-api.svg?maxAge=2592000)](https://github.com/mosufy/lumen-api/releases)

Foundation for API-centric Architecture with Lumen.

Kick-start your development for an api-centric web application with 
this repository! Built with OAuth2 for authorization and authentication.

## Basic Features

- [x] [Built on Lumen 5.2](https://lumen.laravel.com/)
- [x] MVC with Repository Pattern
- [x] RESTful API endpoints
- [x] Event-driven design
- [x] [Requests and Responses based on JSON API Specification](http://jsonapi.org/)
- [ ] [PHPDocumentor](https://www.phpdoc.org/)
- [x] [Codeception Code Coverage and API Tester](http://codeception.com/)
- [x] Build status and Code Coverage Report with [Travis CI](https://travis-ci.org) and [Codecov](https://codecov.io)
- [x] Mailgun transactional email integration with queues
- [x] [OAuth2 for authorization](https://en.wikipedia.org/wiki/OAuth)
- [x] [In-memory cache with memcached](https://lumen.laravel.com/docs/5.2/cache)
- [x] [Message queue service with Redis](https://lumen.laravel.com/docs/5.2/queues)
- [x] [Elasticsearch for fast and real-time search](https://www.elastic.co/products/elasticsearch)
- [ ] Elasticsearch distributed index with replication for fail-overs (sharding with replication)
- [x] Example TODO API resource endpoints
- [x] [Facade-free implementation](http://taylorotwell.com/response-dont-use-facades/)
- [ ] Eloquent-free implementation
- [ ] ReactJS for views
- [x] Jenkins-ready deployment
- [x] Local setup using Vagrant and VirtualBox
- [x] API access logs for possible rate limiting
- [x] App logs saved to daily log file & database
- [x] Multi-tenant environment
- [ ] PHP-7 Support

## Installation Instructions

1. Download and install VirtualBox and Vagrant

   **Vagrant** - Contains VM installation instructions to closely mimic the production box  
   **VirtualBox** - Allows us to run a VM on our local machine
    
   This version of VirtualBox and Vagrant works well on Mac OS X El Capitan Version 10.11.6. Newer versions might work too as long as both VirtualBox and Vagrant are compatible to each other.
   
   - VirtualBox: Version 5.0.18 http://download.virtualbox.org/virtualbox/5.0.18/VirtualBox-5.0.18-106667-OSX.dmg
   - Vagrant: Version 1.8.1 https://releases.hashicorp.com/vagrant/1.8.1/vagrant_1.8.1.dmg
    
2. Go to project root and type `vagrant up`
   
   ```bash
   $ cd Documents/webapps/lumen-api
   $ vagrant up
   ```

3. Vagrant will now begin setting up on your machine based on instructions on the Vagrantfile
  - Setting up headless VM on VirtualBox
  - Install required software on the VM based on `deploy/vagrant/build.sh`
  - Creates database, run migration and seeder, etc. as per build.sh above
    
4. Setup should now be completed with this message

   ```bash
   Done, rebooting
   System reboot successful.
   SSH to vagrant and run 'sudo /etc/init.d/vboxadd setup'. Then, 'vagrant reload' on Terminal.
   ```
    
5. Type `vagrant ssh` to SSH into the VM

   ```bash
   $ vagrant ssh
   ```
    
6. Type `sudo /etc/init.d/vboxadd setup` to update the Guest Additions. This is required to allow VirtualBox access to the local project root folder

   ```bash
   $ sudo /etc/init.d/vboxadd setup
   ```
    
7. Exit the VM and type `vagrant reload` to reload the VM with the newly installed Guest Additions

   ```bash
   $ vagrant reload
   ```
    
   SSH into vagrant to confirm that you are now able to access the local folder from VM
    
   ```bash
   $ vagrant ssh
   ...
   $ cd /var/www/lumenapi
   $ ls -l
   ```
   
   Above should list all the files as per your local project root folder
    
8. Create `.env` from existing `.env.exmple`

   ```bash
   $ cp .env.example .env
   ```
    
*Enjoy!*
    
## Accessing the API

It is recommended to download and use Postman to access all of the API endpoints.

To access the web app, enter the VM ip address in your hosts file. This ip address can be found in the Vagrantfile

```bash
$ vim /etc/hosts
...
10.1.2.100       api.lumenapi.local
...
```
    
You should now be able to access the local web app by typing http://api.lumenapi.local

Ping test endpoint: http://api.lumenapi.local/v1/services/ping

```json
{"data":[{"type":"timestamp","id":null,"attributes":{"timestamp":{"date":"2016-08-29 17:38:37.000000","timezone_type":3,"timezone":"UTC"}}}]}
```

## Accessing the Database

It is recommended to download and use SequelPro to access the database.

Refer to the `.env` for the DB ip address. In any case, below is the DB credentials:

```bash
MySQL Host: 127.0.0.1
Username: lumenapi
Password: password
Database: lumenapi
Port: 3306
SSH Host: 10.1.2.100
SSH User: vagrant
SSH Key: `<project_root>/.vagrant/machines/default/virtualbox/private_key`
```

## Elasticsearch

[Elasticsearch](https://www.elastic.co/products/elasticsearch) is a distributed, open source search and analytics engine.

### Importing indexes

Before we can begin to query, the index is required to be imported first.

```
$ php artisan elasticsearch:importIndex {--index=} {--type=}
```

### Accessing the GUI

This build of vagrant comes with Elasticsearch GUI powered by [Jettro Coenradie](http://www.gridshore.nl/). 

To access the GUI, simply access via `http://<vm_ip_address>:9200/_plugin/gui/index.html#/dashboard`.

## Running Queued Jobs

Tasks that require a significant amount of time to process (like sending
out an email), should be  handled asynchronously. This can be handled 
by utilising Laravel Queues. To see events and queues in action, create 
an account by send a `POST` request to `/account` (see Postman collection).

Notice that the account has been created but the email is not sent. This
is because the job is being sent to the queue. Run the queue listener:

```
$ php artisan queue:listen --queue=high,default,low
```

You will start to observe `Processed: App\Jobs\SendMailer`, indicating
that the queued job has now been processed. No email has been sent out
as the `MAIL_PRETEND` in .env is set to `true`.

Refer to the [Lumen Queues](https://lumen.laravel.com/docs/5.2/queues) 
to understand more of how Queue works.

## Codeception Testing

Full suite testing the elegant and efficient way.

### To run test cases

```bash
$ vendor/bin/codecept run
```

### To run test cases with code coverage

1. Install Xdebug

   ```bash
   $ sudo yum install php56w-pecl-xdebug
   ```

2. Run test with code coverage

   ```bash
   $ vendor/bin/codecept run --coverage --coverage-xml --coverage-html
   ```
   
   To view code coverage report, the file is located in `tests/_output/coverage/index.html`

## Don't use Facades

First commented as a Reddit post, and as agreed by Taylor Otwell himself 
as a bad practice, Laravel 5.0 and above are now having lesser dependence 
on facades. Taylor now provides alternatives to Facades in its 
Documentations. Read the [original content](https://www.reddit.com/r/PHP/comments/1v0p6h/stop_using_facades/) 
and Taylor's response [here](http://taylorotwell.com/response-dont-use-facades/).

## Eloquent-free Implementation

Eloquent and Facades are known to slow down the performance. That is why
Lumen is shiped out with Facades and Eloquent disabled. In this feature,
we will explore other alternatives like Doctrine2 and others.

## Author

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)

## Contributing

Fork and merge request!

## License

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
