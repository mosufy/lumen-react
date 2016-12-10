App deploy
=========

This role will deploy app to webserver.

Role Variables
--------------

Refer to defaults/main.yml for all variables.

Example Playbook
----------------

    - name: Deploy app
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.app

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
