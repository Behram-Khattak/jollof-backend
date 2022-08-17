<?php

namespace Deployer;

\Dotenv\Dotenv::createImmutable(__DIR__)->load();

require 'recipe/laravel.php';

// Project name
set('application', env('APP_NAME'));

// Project repository
set('repository', 'git@github.com:Estauray-Business-Solution/jollof-backend.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

set('ssh_multiplexing', false);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);

set('bin/npm', function () {
    return run('which npm');
});

// Hosts
host('testing')
    ->hostname(env('TEST_SERVER_IP_ADDRESS'))
    ->set('deploy_path', '/var/www/{{application}}')
    ->identityFile(env('TEST_SERVER_SSH_KEY'))
    ->set('branch', 'develop')
    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader --no-suggest')
    ->stage('testing')
    ->user('root');

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});
// task('deploy:vendors', function(){
//     run("cd {{application}}/bootstrap && mkdir cache");
// });

desc('Restart Apache service');
task('apache:restart', 'sudo systemctl restart apache2.service');

desc('Install npm packages');
task('npm:install', function () {
    if (has('previous_release')) {
        if (test('[ -d {{previous_release}}/node_modules ]')) {
            run('cp -R {{previous_release}}/node_modules {{release_path}}');

            // If package.json is unmodified, then skip running `npm install`
            if (!run('diff {{previous_release}}/package.json {{release_path}}/package.json')) {
                return;
            }
        }
    }
    run('cd {{release_path}} && {{bin/npm}} install');
});

desc('Build application assets');
task('npm:build', function () {
    set('deploy_path', '...');

    run('npm install && npm run prod');

    echo 'NPM build done';
})->local();

desc('Create env file from example env file');
task('env:copy', function () {
    run('cd {{release_path}} && {{bin/composer}} run-script post-root-package-install');
});

desc('Generate application key');
task('key:generate', function () {
    if (!has('previous_release')) {
        run('cd {{release_path}} && {{bin/composer}} run-script post-create-project-cmd');
    }
});

desc('Upload application assets');
task('upload:assets', function () {
    set('hostname', env('TEST_SERVER_IP_ADDRESS'));
    set('user', 'root');

    runLocally('scp -r public/css {{user}}@{{hostname}}:{{release_path}}/public/');
    runLocally('scp -r public/fonts {{user}}@{{hostname}}:{{release_path}}/public/');
    runLocally('scp -r public/js {{user}}@{{hostname}}:{{release_path}}/public/');
    runLocally('scp -r public/mix-manifest.json {{user}}@{{hostname}}:{{release_path}}/public/');
    runLocally('scp -r public/images {{user}}@{{hostname}}:{{release_path}}/public/', [
        'timeout' => 1800,
    ]);
});

desc('Execute artisan config:clear');
task('artisan:config:clear', function () {
    run('{{bin/php}} {{release_path}}/artisan config:clear');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

after('deploy:vendors', 'env:copy');

after('env:copy', 'key:generate');

after('key:generate', 'npm:build');

// Migrate database after updating code.
before('deploy:symlink', 'artisan:migrate');

// Cmment this line to deploy without assets
//after('artisan:migrate', 'apache:restart');

after('artisan:config:cache', 'artisan:config:clear');

// Restart apache service after successful deploy - with assets
after('artisan:migrate', 'upload:assets');

after('upload:assets', 'apache:restart');
