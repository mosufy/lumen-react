Deploy Supervisord
=========

This role will run deployment tasks on Supervisord server

Role Variables
--------------

- **queue_name**  
  the name of the queue
- **app_path**  
  Absolute path of the app
- **app_env**  
  Environment to run the supervisord deploy

Example Playbook
----------------

    - name: Deploy Supervisord
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.supervisord-deploy

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
