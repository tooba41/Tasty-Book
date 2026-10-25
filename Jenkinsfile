
pipeline {
    agent any

    stages {
        stage('Checkout Tasty-Book') {
            steps {
                checkout scm
                sh 'ls -la'
            }
        }

        stage('Build Application Image') {
            steps {
                sh 'docker build -t tastybook-web:latest .'
            }
        }

        stage('Load Image into Minikube') {
            steps {
                sh '''
                    sudo -n -u ec2-user -H \
                      /usr/local/bin/minikube image load tastybook-web:latest
                '''
            }
        }

        stage('Update Database Secret') {
            steps {
                withCredentials([
                    string(credentialsId: 'tastybook-db-password',
                           variable: 'DB_PASSWORD'),
                    string(credentialsId: 'tastybook-db-root-password',
                           variable: 'DB_ROOT_PASSWORD')
                ]) {
                    sh '''
                        set +x
                        kubectl create secret generic tastybook-db-secret \
                          --from-literal=DB_PASSWORD="$DB_PASSWORD" \
                          --from-literal=DB_ROOT_PASSWORD="$DB_ROOT_PASSWORD" \
                          --dry-run=client -o yaml |
                          kubectl apply -f -
                    '''
                }
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                sh '''
                    kubectl apply -f k8s/tastybook.yaml
                    kubectl rollout status deployment/tastybook-db \
                      --timeout=180s
                    kubectl rollout status deployment/tastybook-web \
                      --timeout=180s
                '''
            }
        }

        stage('Verify Deployment') {
            steps {
                sh '''
                    kubectl get pods
                    kubectl get services

                    set +x
                    kubectl port-forward service/tastybook-web \
                      18080:80 >/tmp/tastybook-port-forward.log 2>&1 &
                    PF_PID=$!
                    trap 'kill "$PF_PID" 2>/dev/null || true' EXIT

                    for i in $(seq 1 15); do
                        if curl -fsS http://127.0.0.1:18080/; then
                            echo "Application HTTP check passed."
                            exit 0
                        fi
                        sleep 2
                    done

                    cat /tmp/tastybook-port-forward.log
                    echo "Application HTTP check failed."
                    exit 1
                '''
            }
        }
    }

    post {
        success {
            echo 'Tasty-Book Kubernetes deployment completed.'
        }
        failure {
            echo 'Deployment failed. Check the Jenkins Console Output.'
        }
    }
}
