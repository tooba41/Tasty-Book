
pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                echo 'Tasty-Book CI/CD Pipeline Started'
                checkout scm
            }
        }

        stage('Verify Project Files') {
            steps {
                sh 'ls -la'
                echo 'Tasty-Book files checked successfully.'
            }
        }
    }

    post {
        success {
            echo 'Tasty-Book pipeline completed successfully!'
        }
        failure {
            echo 'Tasty-Book pipeline failed. Check the console output.'
        }
    }
}
