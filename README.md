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

*Note: to pull the image, run: `docker pull europe-central2-docker.pkg.dev/$GOOGLE_CLOUD_PROJECT/docker-repo/php-app:latest`

## 2. Automate Build Docker Image 
Configure it via Cloud Shell -> Cloud Build -> Triggers

*Note1: Enable Cloud Build Api

*Note2: Command line can be inferred from: https://cloud.google.com/build/docs/automating-builds/create-manage-triggers?&_ga=2.230316508.-1599207252.1635362861#build_trigger

## 3. Manual Docker Image Deployment




## 4. Automate Docker Image Deployment

## 5. Expose your service over Cloud Load Balancer (Ingress) with an external static IP address

## 6. Connect to Database using Cloud SQL Auth Proxy 

## 7. Manual SQL migration scripts 

## 8. Automate SQL migration scripts 




