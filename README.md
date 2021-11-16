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

`docker build -t php-app:0.0.1 .`

- Test created image:

`docker run -p 8080:80 php-app:0.0.1 `

- Push the Docker image into the Artifact Repository

`docker tag php-app:0.0.1 gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:0.0.1`

ContainerRepo `docker push gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:0.0.1`

Artifact Repository

`gcloud artifacts repositories create docker-repo --repository-format=docker \
--location=europe-central2 --description="Docker repository"`

List all repos:

`gcloud artifacts repositories list`

Setup authentication:

`gcloud auth configure-docker europe-central2-docker.pkg.dev`


Tag it for Artifact Registry:

`docker tag php-app:0.0.1
europe-central2-docker.pkg.dev/$GOOGLE_CLOUD_PROJECT/docker-repo/php-app:0.0.1`

Push it to Artifact Registry:

`docker push europe-central2-docker.pkg.dev/$GOOGLE_CLOUD_PROJECT/docker-repo/php-app:0.0.1`

In Cloud Shell go to Artifact Registry and check out your image

*Note: to pull the image, run: `docker pull europe-central2-docker.pkg.dev/$GOOGLE_CLOUD_PROJECT/docker-repo/php-app:0.0.1`

## 2. Automate Build Docker Image 
Configure it via Cloud Shell -> Cloud Build -> Triggers

*Note1: Enable Cloud Build Api

*Note2: Command line can be inferred from: https://cloud.google.com/build/docs/automating-builds/create-manage-triggers?&_ga=2.230316508.-1599207252.1635362861#build_trigger

## 3. Manual Docker Image Deployment
*Note1: Enable Kubernetes Engine Api
*Note2: set region

Create cluster:

`gcloud container clusters create php-cluster`

Note: There was problem with quotas -> by default GKE needs 9 IP adressess for full cluster. Read more here: https://ncona.com/2021/11/gke-insufficient-regional-quota-to-satisfy-request-resource-in-use-addresses


Get credentials to cluster:
`gcloud container clusters get-credentials php-cluster`

Create Kubernetes deployment:
`kubectl create deployment php-app --image=gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:0.0.1`

Or using deployment config:
`kubectl create -f deployment.yaml`

// Update the image

`docker build -t php-app:0.0.2 .`

`docker tag php-app:0.0.2 gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:0.0.2`

`docker push gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:0.0.2`

`kubectl edit deployment php-app`

## 4. Automate Docker Image Deployment




## 5. Expose your service over Cloud Load Balancer (Ingress) with an external static IP address

Expose service:
`kubectl expose deployment php-app --type=LoadBalancer --port 8080`

## 6. Connect to Database using Cloud SQL Auth Proxy 

## 7. Manual SQL migration scripts 

## 8. Automate SQL migration scripts 




