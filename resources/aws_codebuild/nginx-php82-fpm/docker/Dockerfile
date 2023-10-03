FROM wyveo/nginx-php-fpm:php82

# copy project in container
COPY ./ /usr/share/nginx/html

# Nginx Config (Override Container Config)
COPY ./aws_codebuild/nginx-php82-fpm/docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY ./aws_codebuild/nginx-php82-fpm/docker/nginx/nginx.conf /etc/nginx/nginx.conf

# php-fpm Config (Override Container Config)
COPY ./aws_codebuild/nginx-php82-fpm/docker/php/pool.d/www.conf /etc/php/8.2/fpm/pool.d/www.conf
COPY ./aws_codebuild/nginx-php82-fpm/docker/php/php.ini /etc/php/8.2/fpm/php.ini

# 修正 upgrade 錯誤
# https://github.com/phusion/baseimage-docker/issues/542
RUN echo 'DPkg::options { "--force-confdef"; };' >> /etc/apt/apt.conf
RUN apt-get upgrade -y


RUN apt-get update -y &&\
    apt-get install -y -f vim curl &&\
    apt-get clean &&\
    apt-get autoremove &&\
    rm -rf /var/lib/apt/lists/* &&\
    rm -rf /tmp/pear
