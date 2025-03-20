# LAMP Stack Deployment with Reverse Proxy & Monitoring

This project sets up a **React frontend**, **PHP backend**, **MySQL database**, and **APACHE as a web server and  reverse proxy** for handling requests. The entire application is **Dockerized**, and logs are sent to **AWS CloudWatch**, with **CloudWatch Agent** monitoring memory usage and disk.

## **Project Structure**

```
.
├── frontend/       # React App (Served by Apache on port 80)
├── api/            # PHP App (listening on port 5000)
├── db/             # MySQL Database in Docker on port 3306       
├── docker-compose.yml
└── README.md
```

## **AWS EC2 Deployment Steps**

### **1. Launch an EC2 Instance**
- Use **Ubuntu 20.04+**.
- Choose an instance type (`t2.micro` for testing, `t3.medium` or higher for production).
- Allow inbound rules for **HTTP (80)**, and **SSH (22)** and **Custom TCP (5000)**.

### **2. Create IAM Role And Attach it to the Instance**
add the following permissions to the IAM ROLE
- `CloudWatchFullAccess` permissions policy.
- `AmazonSSMManagedInstanceCore` permissions policy.
- `CloudWatchAgentServerPolicy` permissions policy.
- `AmazonEC2FullAccess` permissions policy.

### **3. Creation of Cloudwatch Log-group and log-stream**
- Log Group Name **docker-logs**
- log-stream Name **app-logs**
- log-stream Name **web-logs**
- log-stream Name **mysql-logs**
![alt text](image.png)
![alt text](image-1.png)

### **4. Configure CloudWatch agent to collect memory usage and disk metrics**
- Select your instance,Monitoring tab and click Configure CloudWatch agent
![alt text](image-2.png)
- Select Memory and Disk 
![alt text](image-3.png)

### **5. Connect to the Instance**

```sh
    ssh -i your-key.pem ubuntu@your-ec2-public-ip
```
## Install Required Packages
```sh
    for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc; do sudo apt-get remove $pkg; done
    # Add Docker's official GPG key:
    sudo apt-get update
    sudo apt-get install ca-certificates curl
    sudo install -m 0755 -d /etc/apt/keyrings
    sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
    sudo chmod a+r /etc/apt/keyrings/docker.asc

    # Add the repository to Apt sources:
    echo \
    "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
    $(. /etc/os-release && echo "${UBUNTU_CODENAME:-$VERSION_CODENAME}") stable" | \
    sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```
## Install Docker and Docker Compose
```sh
    sudo apt-get update
    sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
    sudo apt-get install docker-compose
```

## Clone the Repository
```sh
    git clone https://github.com/BINAH25/react-crud-php-api-mysql.git
    cd eact-crud-php-api-mysql
```
## **Reverse Proxy Configuration (APACHE)**
```sh
    vim frontend/apache.conf
```

```apache
    <VirtualHost *:80>
    ServerName 18.202.19.63

    # Serve static files from React build
    DocumentRoot "/var/www/html"
    <Directory "/var/www/html">
        AllowOverride All
        Require all granted
        Options -Indexes +FollowSymLinks
    </Directory>

    # Proxy API requests to the backend
    ProxyPass "/api/" "http://18.202.19.63:5000/"
    ProxyPassReverse "/api/" "http://18.202.19.63:5000/"

    # Allow CORS for API responses (optional)
    <Location "/api/">
        Header set Access-Control-Allow-Origin "*"
        Header set Access-Control-Allow-Methods "GET, POST, OPTIONS, PUT, DELETE"
        Header set Access-Control-Allow-Headers "Origin, X-Requested-With, Content-Type, Accept, Authorization"
    </Location>

    # Log errors
    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

</VirtualHost>

```

### **Build & Run Docker Containers**
```sh
    docker-compose up --build -d
```


## **Monitoring & Logging**
- Logs from React, Apache, and MySQL are sent to AWS CloudWatch.
![alt text](image-4.png)
![alt text](image-5.png)
![alt text](image-6.png)

- AWS CloudWatch Agent is installed to collect **memory usage and disk metrics**.
![alt text](image-8.png)
![alt text](image-7.png)


## **Stopping & Removing Containers**
```sh
    docker-compose down
```

Happy Coding! 🚀
