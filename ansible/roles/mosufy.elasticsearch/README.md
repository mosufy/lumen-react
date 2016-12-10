Elasticsearch
=========

This role will install Elasticsearch

Role Variables
--------------

- **elasticsearch_network_host**  
  ip address of the elasticsearch server
- **elasticsearch_http_port**
  port of the elasticsearch server

Example Playbook
----------------

    - name: Install Elasticsearch
      hosts: all
      become: true
      become_method: sudo
      roles:
        - mosufy.elasticsearch

License
-------

This codebase is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

Author Information
------------------

For any issues with installation or getting this to work, send an email to: [mosufy@gmail.com](mailto:mosufy@gmail.com)
