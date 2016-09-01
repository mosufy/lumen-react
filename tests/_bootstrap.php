<?php
// This is global bootstrap for autoloading

// FIXME: Running codeception on local seem to ignore .env.testing, thus added a temporary fix
// @see https://disqus.com/home/discussion/laracast/get_it_done_with_codeception/#comment-1432719041
putenv('APP_ENV=testing');
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=memcached');