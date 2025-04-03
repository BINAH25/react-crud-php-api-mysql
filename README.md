# LAMP Stack Deployment on Amazon ECS

## Project Overview
This project focuses on deploying a containerized LAMP (Linux, Apache, MySQL, PHP) application to Amazon Elastic Container Service (ECS). The ECS environment ensures scalability, management, and orchestration of containers, providing high availability, reliability, and flexibility.

## Prerequisites
Before starting, ensure you have the following:

### AWS Account
- An AWS account with appropriate permissions to deploy resources in ECS, ECR, and other AWS services.

### Docker Knowledge
- Familiarity with Docker to build and containerize the LAMP application.

### Required Tools
- **AWS CLI**: Install and configure AWS CLI to interact with AWS services.
- **Docker**: Install Docker for containerization.
- **Jenkins**: install Jenkins for continuous integration and deployment
- **Sonarqube**: install sonarqube for code analysis


### IAM Permissions
Ensure your IAM user or role has the necessary permissions for the following AWS services:
- **ECS** (Elastic Container Service)
- **ECR** (Elastic Container Registry)
- **CloudWatch** (Monitoring and Logging)

## Deployment Pipeline
The project includes a Jenkins pipeline that automates the build and deployment process. The pipeline follows these stages:

1. **Fetch Code**: jenkins Pulls the latest code from the GitHub repository.
2. **Check for Backend Changes**: Identifies changes in the `api/`  or `frontend/` directory to determine if a rebuild is necessary.
3. **SonarQube Analysis**: Runs SonarQube for static code analysis.
4. **Build App Image**: Builds a Docker image for the backend API.
5. **Scan Image with Trivy**: Scans the Docker image for vulnerabilities.
6. **Upload Image to ECR**: Pushes the Docker image to AWS Elastic Container Registry (ECR).
7. **Deploy to ECS**: Updates the ECS service with the new image, triggering a new deployment.

![alt text](image-1.png)


![alt text](image.png)

## How to Set Up the Pipeline
### 1. Clone the Repository
```sh
git clone https://github.com/BINAH25/react-crud-php-api-mysql.git
```

### 2. Configure AWS CLI
```sh
aws configure
```

### 3. Set Up Jenkins and Required Plugins
- Install Jenkins and the following plugins:
  - Pipeline
  - Docker Pipeline
  - AWS Credentials
  - Amazon ECR plugin
  - Amazon Web Services SDK
  - SonarQube Scanner
  - Pipeline: AWS Steps
  - Pipeline Utility Steps
  - NodeJS
- Add AWS credentials to Jenkins.

### 4. Define Jenkins Pipeline Script
- Configure `Jenkinsfile` as described in the project.

### 5. Run the Pipeline
- Trigger the Jenkins pipeline to deploy the application.

## Monitoring and Logging
- Use **AWS CloudWatch** for logs and monitoring ECS tasks.
- Enable **CloudTrail** for AWS activity logs.

## Security Best Practices
- Use **IAM roles** for ECS tasks to control permissions securely.
- Store **sensitive data** (e.g., database credentials) in **AWS Secrets Manager** 
- Enable **image scanning** in ECR to detect vulnerabilities before deployment.

## Conclusion
This project provides a structured approach to deploying a containerized LAMP stack on AWS ECS with a CI/CD pipeline. By leveraging Jenkins, Docker, and AWS services, the deployment process is automated, secure, and scalable.

