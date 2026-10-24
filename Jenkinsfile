pipeline {
    agent any

    stages {
        stage('Checkout Tasty-Book') {
            steps {
                checkout scm
                sh 'ls -la'
            }
        }

        stage('Validate Docker Configuration') {
            steps {
                withCredentials([
                    string(credentialsId: 'tastybook-db-password', variable: 'DB_PASSWORD'),
                    string(credentialsId: 'tastybook-db-root-password', variable: 'DB_ROOT_PASSWORD')
                ]) {
                    sh 'docker compose config -q'
                }
            }
        }

        stage('Build Tasty-Book Image') {
            steps {
                withCredentials([
                    string(credentialsId: 'tastybook-db-password', variable: 'DB_PASSWORD'),
                    string(credentialsId: 'tastybook-db-root-password', variable: 'DB_ROOT_PASSWORD')
                ]) {
                    sh 'docker compose build web'
                }
            }
        }

        stage('Deploy Application and Database') {
            steps {
                withCredentials([
                    string(credentialsId: 'tastybook-db-password', variable: 'DB_PASSWORD'),
                    string(credentialsId: 'tastybook-db-root-password', variable: 'DB_ROOT_PASSWORD')
                ]) {
                    sh '''
                        docker compose up -d
                        docker compose ps
                    '''
                }
            }
        }

        stage('Verify Deployment') {
            steps {
                sh 'docker ps'
                sh 'curl --retry 5 --retry-delay 5 --retry-connrefused -f http://localhost/'
            }
        }
    }

    post {
        success {
            echo 'Tasty-Book Docker deployment completed.'
        }
        failure {
            echo 'Deployment failed. Check the Jenkins console output.'
        }
    }
}
