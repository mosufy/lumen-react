DBServer
=========

This role will build a Percona database server. Note that MariaDB will be removed if already exists.

Role Variables
--------------

- **mysql_root_password**  
  Define the MySQL root password
- **mysql_slow_query_log**  
  Set if slow query log should be enabled
- **mysql_long_query_time**  
  Set the time to wait before slow query is being logged

Example Playbook
----------------

    - name: Build DBServer
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.dbserver

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
