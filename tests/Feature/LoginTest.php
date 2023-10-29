<?php

it('redirects to app')->get('/')->assertStatus(302);

it('shows login page')->get('/app/login')->assertStatus(200);
