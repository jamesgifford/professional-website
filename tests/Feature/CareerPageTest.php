<?php

test('career page loads successfully', function () {
    $response = $this->get(route('career'));

    $response->assertStatus(200);
    $response->assertSeeText('Career');
});

test('career page includes contact section', function () {
    $response = $this->get(route('career'));

    $response->assertSee('id="contact"', false);
    $response->assertSee("Let's Connect", false);
});

test('homepage includes contact section', function () {
    $response = $this->get(route('home'));

    $response->assertSee('id="contact"', false);
    $response->assertSee("Let's Connect", false);
});

test('career link appears in navigation', function () {
    $response = $this->get(route('career'));

    $response->assertSee(route('career'), false);
});
