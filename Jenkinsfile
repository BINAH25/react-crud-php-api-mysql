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


        stage('SonarQube analysis') {
            environment {
                scannerHome = tool 'sonar4.7'
            }
            steps {
                withSonarQubeEnv('sonar') {
                    sh "${scannerHome}/bin/sonar-scanner"
                }
            }
        }

        // stage("Build") {
        //     steps {
        //         script {
        //             sh """
        //                 cd frontend
        //                 npm ci --legacy-peer-deps
        //                 npm run build
        //             """
        //         }
        //     }
        // }

    }

}