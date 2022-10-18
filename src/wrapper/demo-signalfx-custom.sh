#curl --request POST \
#  --header "Content-Type: application/json" \
#  --header "X-SF-TOKEN: rb2yT1_ej4yXYkIdSQzp_w" \
#  --data \
#  '{ "gauge": [{
#       "metric": "game-ecointet.current_players",
#       "value": 3
#  }]}' \
#https://ingest.us0.signalfx.com/v2/datapoint

curl  --request PUT \
    --header "X-SF-TOKEN: rb2yT1_ej4yXYkIdSQzp_w" \
    --header "Content-Type: application/json" \
    --data \
        '{
            "key" : "game-ecointet_info",
            "value": "game-ecointet",
            "tags": ["game-ecointet"],
            "customProperties": {
                "player-name" : "Damien",
                "ip-player" : "86.4.67.9.1"
                }
        }' \
    https://api.us0.signalfx.com/v2/dimension/game-ecointet_info/game-ecointet