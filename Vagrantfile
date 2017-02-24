# -*- mode: ruby -*-
# vi: set ft=ruby :

# Install dependencies
required_plugins = %w( vagrant-hostmanager )
required_plugins.each do |plugin|
  exec "vagrant plugin install #{plugin};vagrant #{ARGV.join(" ")}" unless Vagrant.has_plugin? plugin || ARGV[0] == 'plugin'
end

Vagrant.configure(2) do |config|

  # Hostmanager configuration
  config.hostmanager.enabled = true
  config.hostmanager.manage_host = true
  config.hostmanager.manage_guest = true
  config.hostmanager.ignore_private_ip = false
  config.hostmanager.include_offline = true

  config.vm.define "webserver", primary: true do |app|
    app.vm.box = "bento/centos-7.3"
    app.vm.hostname = 'lumen-react.dev'
    app.hostmanager.aliases = %w(api.lumen-react.dev)
    app.vm.network "private_network", ip: "10.1.2.100", auto_network: true
    app.ssh.shell = "bash -c 'BASH_ENV=/etc/profile exec bash'"
    app.vm.synced_folder '.', '/vagrant', disabled: true
    config.vm.synced_folder "./", "/var/www/sites/lumen-react/html", :nfs => { :mount_options => ["dmode=777","fmode=777"] }

    app.vm.provider "virtualbox" do |vb|
      vb.customize ["modifyvm", :id, "--memory", "2048"]
      vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
      vb.customize ["modifyvm", :id, "--cableconnected1", "on"]
    end
  end

  # Build provision
  config.vm.provision "build", type:"ansible" do |ansible|
    ansible.playbook = "ansible/build.yml"
    ansible.inventory_path = "ansible/inventories/dev/hosts.ini"
    ansible.galaxy_role_file = "ansible/build_install_roles.yml"
    ansible.galaxy_roles_path = "ansible/roles"
    ansible.galaxy_command = "ansible-galaxy install --role-file=%{role_file} --roles-path=%{roles_path}"
    ansible.limit = 'all'
  end

  # Deploy provision
  config.vm.provision "deploy", type:"ansible" do |ansible|
    ansible.playbook = "ansible/deploy.yml"
    ansible.inventory_path = "ansible/inventories/dev/hosts.ini"
    ansible.galaxy_role_file = "ansible/deploy_install_roles.yml"
    ansible.galaxy_roles_path = "ansible/roles"
    ansible.galaxy_command = "ansible-galaxy install --role-file=%{role_file} --roles-path=%{roles_path}"
    ansible.limit = 'all'
  end

end