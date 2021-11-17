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
Configure it via Cloud Console -> Cloud Build -> Triggers

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
`kubectl create -f k8s/deployment.yaml`

// Update the image

`docker build -t php-app:0.0.2 .`

`docker tag php-app:0.0.2 gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:0.0.2`

`docker push gcr.io/$GOOGLE_CLOUD_PROJECT/php-app:0.0.2`

`kubectl edit deployment php-app`

## 4. Automate Docker Image Deployment
*Note: Create service account for GKE deployment: https://stackoverflow.com/questions/53420870/keep-getting-permissions-error-gcloud-container-clusters-get-credentials

Configuration in Cloud Console: CloudBuild -> Triggers

## 5. Expose your service over Cloud Load Balancer (Ingress) with an external static IP address

Expose service(cmd):
`kubectl expose deployment php-app --type=LoadBalancer --port 8080`

Create service via yaml config file: php/k8s/service.yaml

## 6. Connect to Database using Cloud SQL Auth Proxy 
CloudConsole: SQL -> MySQL

Create secrets:

`kubectl create secret generic <SECRET-NAME> \
    --from-literal=username=<DB-USER> \
    --from-literal=password=<DB-PASS> \
    --from-literal=database=<DB-NAME>`


if you want to delete it:
`kubectl delete secret php-db-secret --ignore-not-found`

Create key for service account:
`gcloud iam service-accounts keys create ~/key.json \
  --iam-account php-db-account@gcp-training-final-task.iam.gserviceaccount.com`

Load key to GKE:
`kubectl create secret generic php-db-account-secret \
--from-file=service_account.json=./key.json`


## 7. Manual SQL migration scripts 

Run Cloud SQL Auth Proxy from docker:

`docker run -d -p 127.0.0.1:3306:3306 gcr.io/cloudsql-docker/gce-proxy:1.19.1 /cloud_sql_proxy  -instances=gcp-training-final-task:europe-central2:php-db=tcp:0.0.0.0:3306`

Run Migration from script:

`docker run -v ~/github_hessonit_gcp_training/migration/:/migrations --network host migrate/migrate -path=/migrations/ -database "mysql://root:password@tcp(localhost:3306)/php_db" up 1`

*up N -> upgrate N migrations

**down N -> downgrade N migrations


## 8. Automate SQL migration scripts 




