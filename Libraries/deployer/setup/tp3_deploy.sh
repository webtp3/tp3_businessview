#!/bin/bash
#

echo "deploy start"
git clone git@bitbucket.org:connecta-ag/cag_project.git mynewproject_www
git fetch && git checkout develop
