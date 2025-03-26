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

        stage('Check for frontend changes') {
            steps {
                script {
                    def changedFiles = sh(script: "git diff --name-only HEAD~1 HEAD", returnStdout: true).trim()
                    def frontendChanged = changedFiles.split("\n").any { it.startsWith("frontend/") }
                    
                    if (!frontendChanged) {
                        echo "No changes detected in frontend. Skipping build."
                        currentBuild.result = 'SUCCESS'
                        error("Skipping remaining stages.")  // Stop pipeline execution
                    } else {
                        echo "Changes detected in frontend. Proceeding with the build."
                    }
                }
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
