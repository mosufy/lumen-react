DBServer deploy
=========

This role will run deployment tasks on dbserver.

Role Variables
--------------

- **mysql_root_password**  
  Set the MySQL root password
- **db_database**  
  Assign database name for app
- **db_username**  
  Assign database username
- **db_password**  
  Assign database user password
- **deploy_type**  
  new=drop db; update=no dropping of db; none=do nothing

Example Playbook
----------------

    - name: Deploy database
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.dbserver-deploy

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
