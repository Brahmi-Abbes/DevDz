<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

// Home page loads
it('shows the home page', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
});

// Guest cannot create post
it('guest cannot create a post', function () {
    $response = $this->post('/posts', []);
    $response->assertRedirect('/login');
});