# Define variables for your ECR repository and image tag (use git commit or any other tag strategy you prefer)
ECR_REPO=539779309746.dkr.ecr.us-west-2.amazonaws.com/wordpress
TAG=$(shell git rev-parse --short HEAD)

# Define your environments as needed
.PHONY: build push deploy-all deploy-dev deploy-prod

build:
	buildah bud -t $(ECR_REPO):$(TAG) .

push:
	# Login to ECR using AWS CLI v2 (The 'aws ecr get-login-password' command gets the auth token)
	aws ecr get-login-password --region us-west-2 | buildah login --username AWS --password-stdin $(ECR_REPO)
	buildah push $(ECR_REPO):$(TAG)

deploy-all: deploy-dev deploy-prod

deploy-dev:
	# Command to update your Kubernetes deployment in dev
	kubectl set image deployment/wordpress_2nd.yaml wordpress-container=$(ECR_REPO):$(TAG) --namespace wordpress

deploy-prod:
	# Command to update your Kubernetes deployment in prod
	# Example: kubectl set image deployment/your-deployment-name wordpress-container=$(ECR_REPO):$(TAG) --namespace your-prod-namespace

# Example usage: make build push deploy-all

