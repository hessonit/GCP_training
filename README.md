This repository contains scripts related to the final task of GCP course.


Work in progress

Set location:

`gcloud config set compute/region europe-central2`


# Tasks
## 1. Manual Build Docker Image
scripts are in the php directory

- Copy the repo: 

`gcloud source repos clone github_hessonit_gcp_training`

- Go to "php" directory:

`cd php`

- Build docker image:

`docker build -t php-app:latest .`

- Test created image:

`docker run -p 8080:80 php-app:latest `

- Push the Docker image into the Artifact Repository

`docker tag php-app:latest gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:latest`

ContainerRepo `docker push gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:latest`

Artifact Repository

`gcloud artifacts repositories create docker-repo --repository-format=docker \
--location=europe-central2 --description="Docker repository"`

List all repos:

`gcloud artifacts repositories list`

Setup authentication:

`gcloud auth configure-docker europe-central2-docker.pkg.dev`


Tag it for Artifact Registry:

`docker tag php-app:latest
europe-central2-docker.pkg.dev/$GOOGLE_CLOUD_PROJECT/docker-repo/php-app:latest`

Push it to Artifact Registry:

`docker push europe-central2-docker.pkg.dev/$GOOGLE_CLOUD_PROJECT/docker-repo/php-app:latest`

In Cloud Shell go to Artifact Registry and check out your image

## 2. Automate Build Docker Image 
TODO





