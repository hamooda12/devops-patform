FROM ubuntu:22.04

RUN apt-get update -y && \
    apt-get install -y git && \
    git config --global user.email "student@example.com" && \
    git config --global user.name "Student" && \
    apt-get clean

WORKDIR /workspace