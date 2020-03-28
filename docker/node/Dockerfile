FROM node:8.10.0

RUN apt-get update && apt-get install -y vim

RUN mkdir /root/.ssh
RUN chmod -R 0775 /root/.ssh

RUN ssh-keyscan gitlab.com >> /root/.ssh/known_hosts