<?php

test('home page loads successfully', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('home page displays name and title', function () {
    $response = $this->get('/');

    $response->assertSee('James Gifford');
    $response->assertSee('Software Engineer');
});

test('home page has navigation links', function () {
    $response = $this->get('/');

    $response->assertSee('about');
    $response->assertSee('work');
    $response->assertSee('contact');
});
