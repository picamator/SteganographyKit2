FROM ubuntu:16.04
ARG my_ip

RUN apt-get update

# php
RUN apt-get -y install php7.0
RUN apt-get -y install php7.0-xml
RUN apt-get -y install php7.0-curl
RUN apt-get -y install php7.0-zip
RUN apt-get -y install php7.0-intl
RUN apt-get -y install php7.0-gd

# xdebug
RUN apt-get -y install wget
RUN apt-get -y install php7.0-dev

RUN wget -O ~/xdebug-2.4.1.tgz http://xdebug.org/files/xdebug-2.4.1.tgz
RUN tar -xvzf ~/xdebug-2.4.1.tgz
RUN rm ~/xdebug-2.4.1.tgz
RUN cd xdebug-2.4.1 && phpize
RUN cd xdebug-2.4.1 && ./configure
RUN cd xdebug-2.4.1 && make
RUN cd xdebug-2.4.1 && cp modules/xdebug.so /usr/lib/php/20151012
RUN rm -rf xdebug-2.4.1

RUN echo "" >> /etc/php/7.0/cli/php.ini
RUN echo "; xdebug" >> /etc/php/7.0/cli/php.ini
RUN echo "zend_extension = /usr/lib/php/20151012/xdebug.so" >> /etc/php/7.0/cli/php.ini

RUN echo "xdebug.remote_enable = 1" >> /etc/php/7.0/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_autostart = 1" >> /etc/php/7.0/cli/conf.d/20-xdebug.ini
RUN echo "xdebug.remote_host = $my_ip" >> /etc/php/7.0/cli/conf.d/20-xdebug.ini

# graphviz
RUN apt-get -y install graphviz

# git
RUN apt-get -y install git

# composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

# ssh, source https://docs.docker.com/engine/examples/running_ssh_service/ with correction https://github.com/docker/docker/issues/23621#issuecomment-226575258
RUN apt-get -y install openssh-server

RUN mkdir /var/run/sshd
RUN echo 'root:screencast' | chpasswd
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# SSH login fix. Otherwise user is kicked off after login
RUN sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

EXPOSE 22
CMD ["/usr/sbin/sshd", "-D"]

# volume
RUN mkdir /SteganographyKit2
VOLUME /SteganographyKit2
