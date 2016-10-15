Docker
======
Directory contains Dockerfiles per containers:
* /app - application container

Installation
------------
Commands inside installation instructions contains such placeholders:
* `{{my-docker-account}}` your own docker cloud account
* `{{project-path}}` absolute path to SteganographyKit2
* `{{your-ip}}` your ip address, to get it please run `ifconfig`

Moreover it's assumed that:
* Docker was installed, please follow [installation steps](https://docs.docker.com/engine/installation/)
* The [Docker Hub](https://hub.docker.com/) account was created

### Installation with building own Docker image
1. Build image by running command from SteganographyKit2 root directory, `sudo docker build --build-arg my_ip={{your-ip}} -t {{my-docker-account}}/steganographykit2 -f dev/docker/app/Dockerfile .`
2. Check images `sudo docker images`
3. Run container `sudo docker run -d -p 2224:22 -v ~/{{project-path}}/SteganographyKit2:/SteganographyKit2 -t my-docker-account/steganographykit2`
4. Check container by executing command `sudo docker ps`

SSH
---
Please use credentials bellow to connect to container via ssh:

1. user: `root`
2. password: `screencast`
3. ip: 0.0.0.0
4. port: 2224

or just run `ssh root@0.0.0.0 -p 2224`.

Configuration IDE (PhpStorm)
---------------------------- 
### Remote interpreter
1. Use ssh connection to set php interpreter
2. Set "Path mappings": <progect root>->/SteganographyKit2

More information is [here](https://confluence.jetbrains.com/display/PhpStorm/Working+with+Remote+PHP+Interpreters+in+PhpStorm).

### UnitTests
1. Configure UnitTest using remote interpreter. 
2. Choose "Use Composer autoload"
3. Set "Path to script": /SteganographyKit2/vendor/autoload.php
4. Set "Default configuration file": /SteganographyKit2/dev/tests/unit/phpunit.xml.dist

More information is [here](https://confluence.jetbrains.com/display/PhpStorm/Running+PHPUnit+tests+over+SSH+on+a+remote+server+with+PhpStorm).
