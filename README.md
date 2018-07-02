# PHP Comment Server
[![Build Status](https://travis-ci.org/elyday/comment-server.svg)](https://travis-ci.org/elyday/comment-server)
[![Total Downloads](https://poser.pugx.org/elyday/comment-server/downloads)](https://packagist.org/packages/elyday/comment-server)
[![License](https://poser.pugx.org/elyday/comment-server/license.svg)](https://packagist.org/packages/elyday/comment-server)
[![Latest Stable Version](https://poser.pugx.org/elyday/comment-server/v/stable.svg)](https://packagist.org/packages/elyday/comment-server)
[![Latest Unstable Version](https://poser.pugx.org/elyday/comment-server/v/unstable.svg)](https://packagist.org/packages/elyday/comment-server)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/elyday/comment-server/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/elyday/comment-server/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/elyday/comment-server/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/elyday/comment-server/?branch=master)

This comment server was written using the [PHP Microframework Lumen](https://lumen.laravel.com/) and is used to store, moderate and read comments.

## Configuration
1. To use the Comment Server you must first copy the file `.env.example` and rename it to `.env`.
2. Then you have to specify a key for the app under `APP_KEY` (best with the head over the keyboard).
3. Now you have to enter your database configuration in the `DB_` section. This includes address, user name and password.
4. With `CAPTCHA_SECRET` you now have to define a captcha. This must be answered or sent as soon as someone wants to write a comment.
5. wip...
