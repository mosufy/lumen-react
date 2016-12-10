Basic RPM
=========

This role will install a set of basic, useful RPMs for all servers. This will also install the nginx and webtatic repos.

Example Playbook
----------------

    - name: Install Basic RPMs
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.basic-rpm

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
