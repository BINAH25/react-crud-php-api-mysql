pipeline {
    agent any

    tools {
        nodejs "Node"
    }

    stages {
        stage('Fetch code') {
            steps {
                git branch: 'main', url: 'https://github.com/BINAH25/react-crud-php-api-mysql.git'
            }
        }

        stage("Build") {
            steps {
                script {
                    sh """
                        cd frontend
                        npm ci --legacy-peer-deps
                        npm run build
                    """
                }
            }
        }

    }

}