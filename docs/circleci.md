## Integrating Sido with CircleCI

Integrating Sido into CircleCI is really easy. Here's an example CircleCI `config.yml` file to base your configurations upon:

```yml
version: 2
jobs:
    build:
        docker:
            - {image: "circleci/php:7.3.5-cli"}
            - {image: "circleci/php:7.3.5-node-browsers"}
        working_directory: ~/sido
        steps:
            - checkout
            - run: sudo apt update
            - run: sudo docker-php-ext-install zip
            - {run: {name: "Update composer", command: 'sudo composer self-update'}}
            - restore_cache:
                keys:
                    # "composer.lock" can be used if it is committed to the repo
                    - v1-dependencies-{{ checksum "composer.json" }}
                    # fallback to using the latest cache if no exact match is found
                    - v1-dependencies-
            - run: composer install -n --prefer-dist
            - save_cache:
                key: v1-dependencies-{{ checksum "composer.json" }}
                paths:
                    - ./vendor
            - {run: 'mkdir reports'}
            - {run: {name: "Run test", command: 'php test.php', when: always}}
            - {store_test_results: {path: reports}}
            - {store_artifacts: {path: ./reports/report.xml}}
```

We actually have a whole test which utilizies this. So, if you're really struggling to get started, [see it here](https://github.com/eddiejibson/sido-test)