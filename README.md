# Remote control pioneer
Remote control website for pioneer receiver 

## Description

Project provide a full environment to host a website with an simple interface that allow you to control your receiver.
Features like switch on/off, volume up/down and switch between channels

## Getting Started

### Dependencies

* Docker
* Php 8
* Symfony 6
* Node

### Installing

* Go in docker folder
```
cd .docker
```

* Launch environment 
```
docker-compose up -d
```

* After containers started
```
docker-compose exec -it php make setup
```

You ready to go !

## Acknowledgments

Special thanks to :
* [ui-code/RemoteControl](https://github.com/ui-code/RemoteControl) for the template used for the remote
