# Lumen - API

Foundation for API-centric Architecture with Lumen.

Kick-start your development for an api-centric web application with 
this repository! Built with OAuth2 for authorization and authentication.

## Basic Features

- [x] [Built on Lumen 5.2](https://lumen.laravel.com/)
- [x] MVC with Repository Pattern
- [x] RESTful endpoints
- [x] [OAuth2 for authorization](https://en.wikipedia.org/wiki/OAuth)
- [x] [Based on JSON API Specification](http://jsonapi.org/)
- [ ] [PHPDocumentor](https://www.phpdoc.org/)
- [x] [Codeception Code Coverage and API Tester](http://codeception.com/)
- [ ] ReactJS for views
- [ ] Jenkins-ready deployment
- [x] Local setup using Vagrant and VirtualBox
- [ ] Multi-environment

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
    
You should now be able to access the local web app by typing https://api.lumenapi.local

Ping test endpoint: https://api.lumenapi.local/v1/service/ping

```json
{"data":[{"type":"timestamp","id":null,"attributes":{"timestamp":{"date":"2016-08-29 17:38:37.000000","timezone_type":3,"timezone":"UTC"}}}]}
```

## Accessing the Database

It is recommended to download and use SequelPro to access the database.

Refer to the `.env` for the DB ip address. In any case, below is the DB credentials:

```
MySQL Host: 127.0.0.1
Username: lumenapi
Password: password
Database: lumenapi
Port: 3306
SSH Host: 10.1.2.100
SSH User: vagrant
SSH Key: `<project_root>/.vagrant/machines/default/virtualbox/private_key`
```

## Author

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)

## Contributing

Fork and merge request!

### License

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
