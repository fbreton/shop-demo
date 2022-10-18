# The Pwny Shop!
A Cool Website (desktop & mobile) to demonstrate the Splunk SignalFx real-time monitoring.
Add to your cart as many as items your want, and check out!

![Main Screen](https://github.com/ecointet/shop-demo/blob/master/src/img/github-overview.png?raw=true)

## Features

- Items bought from the last 5 minutes
- Items sold by seconds
- Number of visitors / customers
- CPU / RAM of the Webserver (Nginx)
- Number of requests / seconds
- Simulate buyers / visitors (> 100)
- QR code auto-generated for sharing

## Alerting

- Configure your own SignalFx Detector : Ex: send a slack message if more than 13 items are in cart but not sold.

## Configuration

### STEP 1
`git clone https://github.com/ecointet/shop-demo`
*Requirements : git, docker, docker-compose*

### STEP 2

Edit the file `docker-compose.yml` to set your own variables.
           
            - TOKEN=<SIGNALFX-API-TOKEN>
            - HOST=my-webserver
            - REALM=us0
            - BUYMETRIC=ecointet-buy
            - EMAIL=<YOUR-EMAIL>

[Download this dashboard](https://raw.githubusercontent.com/ecointet/shop-demo/master/template-dashboard.json) and edit it (optional, search & replace):

- Replace **ecointet-buy** with your own metric (cf **BUYMETRIC** from STEP 2).
- Replace **my-webserver** with your own host (cf **HOST** from STEP 2).

Then import the file/dashboard to your [SignalFx app](app.signalfx.com)


### STEP 3

In the main folder (shop-demo), Execute the commande `docker-compose up`

And go to [localhost:8181](http://localhost:8181)

### BONUS

- Debug info in the menu "DEBUG"
- Simulate customers & buyers with the button "Simulate Buyers"
- Share the app with the button "Share with people"
- Customize the app by pasting IMG URLs in the docker-compose.yml file
- Go inside the docker container: docker exec -it shop-demo_php-shop-demo_1 /bin/bash