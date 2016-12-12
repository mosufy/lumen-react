# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|

  config.vm.box = "bento/centos-7.2"

  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.network "private_network", ip: "10.1.2.100"

  config.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"

  config.vm.synced_folder "./", "/var/www/lumen-react", :nfs => { :mount_options => ["dmode=777","fmode=777"] }

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "2048"]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
    vb.customize ["modifyvm", :id, "--cableconnected1", "on"]
  end

  # Build provision
  config.vm.provision "build", type:"ansible" do |ansible|
    ansible.playbook = "ansible/build.yml"
    ansible.inventory_path = "ansible/inventories/dev/hosts.ini"
    ansible.galaxy_role_file = "ansible/install_roles.yml"
    ansible.galaxy_roles_path = "ansible/roles"
    # Using custom galaxy_command so that it will not --force install when role already exists
    ansible.galaxy_command = "ansible-galaxy install --role-file=%{role_file} --roles-path=%{roles_path}"
    ansible.limit = 'all'
  end

  # Deploy provision
  config.vm.provision "deploy", type:"ansible" do |ansible|
    ansible.playbook = "ansible/deploy.yml"
    ansible.inventory_path = "ansible/inventories/dev/hosts.ini"
    ansible.limit = 'all'
  end

end