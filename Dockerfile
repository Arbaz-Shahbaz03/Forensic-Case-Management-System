FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libaio-dev \
    libnsl-dev \
    build-essential \
    pkg-config \
    unzip \
    wget

# Copy already-extracted Instant Client
COPY instantclient_19_29/ /opt/oracle/instantclient_19_29/

ENV LD_LIBRARY_PATH=/opt/oracle/instantclient_19_29
ENV OCI_LIB_DIR=/opt/oracle/instantclient_19_29
ENV OCI_INCLUDE_DIR=/opt/oracle/instantclient_19_29/sdk/include

RUN ln -s /opt/oracle/instantclient_19_29/libclntsh.so.19.1 \
         /opt/oracle/instantclient_19_29/libclntsh.so || true
RUN pecl install oci8-3.3.0 <<EOF
instantclient,/opt/oracle/instantclient_19_29
EOF


RUN a2enmod rewrite

COPY www/ /var/www/html/
