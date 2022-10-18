FROM php:7.1-fpm      

RUN apt-get update && \
    apt-get install -y vim curl wget build-essential nginx supervisor gnupg2

RUN echo "deb http://packages.dotdeb.org jessie all" > /etc/apt/sources.list.d/dotdeb.list && \
    wget https://www.dotdeb.org/dotdeb.gpg && \
    apt-key add dotdeb.gpg

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
    && docker-php-ext-install pdo_mysql mysqli zip

COPY ./default /etc/nginx/sites-enabled
COPY supervisord.conf /etc/

RUN apt-get update
RUN apt-get install -y emacs
#RUN apt-get install -y mysql-server
RUN apt-get install -y apt-transport-https
RUN curl -sSL https://splunk.jfrog.io/splunk/signalfx-agent-deb/splunk-B3CD4420.gpg > /etc/apt/trusted.gpg.d/splunk.gpg
RUN echo 'deb https://splunk.jfrog.io/splunk/signalfx-agent-deb release main' > /etc/apt/sources.list.d/signalfx-agent.list
#RUN curl -sSL https://dl.signalfx.com/debian.gpg > /etc/apt/trusted.gpg.d/signalfx.gpg
#RUN echo 'deb https://dl.signalfx.com/debs/signalfx-agent/final /' > /etc/apt/sources.list.d/signalfx-agent.list
RUN apt-get update
RUN apt-get install -y signalfx-agent
RUN echo "rb2yT1_ej4yXYkIdSQzp_w" > "/etc/signalfx/token"

RUN apt-get install -y stress

COPY ./agent.yaml /etc/signalfx/
#COPY ./sql-script.sql /etc/signalfx/
COPY ./zabbix.py /etc/signalfx/
COPY ./signalfx-agent-beta /etc/signalfx/signalfx-agent-beta
COPY ./10-nginx.conf /etc/collectd/managed_config/

EXPOSE 8000

CMD /etc/init.d/signalfx-agent start && /usr/bin/supervisord -n -c /etc/supervisord.conf
