compose := docker compose

help:                       ## shows this help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_\-\.]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.PHONY: up
up:                                                                     	    ## Start the Docker Compose stack for the complete project
	USER_ID="${UID}" $(compose) up -d --build --remove-orphans

.PHONY: down
down:                                                                           ## Bring down the Docker Compose stack for the complete project
	$(compose) down --volumes

.PHONY: psql
psql:																		    ## psql
	$(compose) exec database psql -d postgres -U postgres
