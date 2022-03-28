I did not have enough time to finish the ui, I kind of went overkill with docker and a mvc.

#How to run

* Go to the root directory and run ``make up``
* For the api go to localhost:8090
* For the ui go to localhost:8091

## Api routes:

* /v1/invoices
* /v1/invoices/{id}
* /v1/invoices/download
* /v1/items/download

```bash
Usage:  make COMMAND

Commands:
help:      Show this help
build:     (Re)build locally the docker images for this application
down:      Stop the docker containers for local development
tail:      Tail the log files of the containers
up:        Start the docker containers for local development
```
