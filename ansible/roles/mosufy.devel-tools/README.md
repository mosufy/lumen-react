Development Tools
=========

This role will install web server development tools.

Role Variables
--------------

- **php_version**  
  Specify the php version to run with. Available versions: [56,70]

Example Playbook
----------------

    - name: Install Devel Tools
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.devel-tools

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
