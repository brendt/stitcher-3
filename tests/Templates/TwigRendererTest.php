<?php

namespace Tests\Templates;

use Tests\TestCase;

class TwigRendererTest extends TestCase
{
    /** @test */
    public function test_render()
    {
        $twigRenderer = $this->container->twigRenderer();

        $output = $twigRenderer->render('twigTest.twig');

        $this->assertStringContainsString('<style>', $output);
    }
}
