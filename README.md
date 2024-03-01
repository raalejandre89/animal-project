## Installation

Follow the following steps to install the necessary components to run the application

- [Install and execute Docker Desktop](https://www.docker.com/products/docker-desktop/).
### Windows
- [Install and enable Windows Subsystem for Linux 2 (WSL2)](https://learn.microsoft.com/en-us/windows/wsl/install).
- After installing and enabling WSL2, you should ensure that Docker Desktop is configured to use the WSL2 backend.
    - How to do this: https://docs.docker.com/desktop/wsl/
- Open a command terminal in your computer and connect to your WSL2 subsystem.
- While in your WSL2 subsystem navigate to the folder where you clone the code.
### Linux
- If you are using Docker Desktop for Linux execute the following ```docker context use default```. If you are not using Docker Desktop for Linux, you may skip this step. 

----------------------------

- After docker is installed and running navigate to the root folder of the project and run ```./vendor/bin/sail up```
  - Instead of repeatedly typing ```vendor/bin/sail``` to execute Sail commands, you can configure a shell alias that allows you to execute Sail's commands more easily: ```alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'``` that way next time instead of executing ```./vendor/bin/sail up``` just run ```sail up```.
- The previous command should set up a redis cluster, a mysql cluster and the application.

## Setting up the Database
- While in your project root folder run the laravel migrations: ```sail artisan migrate:fresh --seed```. This should create all tables for the database and seed the metadata. NOTE: be aware that this will drop all tables before doing any action so if run for the second time it will remove all the data.

##Usage
There are two available commands: one to create animals and another one to list the created animals.
### Create Animals
- Run ```sail artisan create {animalName} {animalType}```
    - ```{animalName}``` could be one name or a comma separated list of names.
    - ```{animalType}``` could be one type or a comma separated list of types.
    - IMPORTANT: the count of names needs to match the count of types.
    - In addition there are three optional arguments ```--ages=``` ```--colors=``` and ```--foods=```. Each could be one value or a comma separated list of values.
    - NOTE: Each value in each argument correspond to the animal in the Nth position in the list. For example in the following command ```sail artisan create Blake,Riki dog,cat --ages=5,6``` Blake is a 5 years old dog and Riki is a 6 years old cat.
### List Animals
- Run ```sail artisan animal:list```
    - After running the command the app will guide you with the different options to list animals.
## Test
- To run the tests run ```sail artisan test```
