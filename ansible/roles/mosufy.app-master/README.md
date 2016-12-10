App deploy master
=========

This role will deploy app to single master webserver.

Role Variables
--------------

- **deploy_type**  
  new | update | none
- **app_path**  
  Absolute path of app
- **app_name**  
  Name of the app
- **web_user**
  User to run command as

Example Playbook
----------------

    - name: Deploy app to master webserver
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.app-master

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
