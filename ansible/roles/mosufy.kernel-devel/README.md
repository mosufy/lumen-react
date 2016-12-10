Kernel-devel
=========

This role will update kernel-devel for Vagrant fix

Example Playbook
----------------

    - name: Update kernel-devel
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.kernel-devel

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
