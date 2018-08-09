<?php
class OptionsRequestTest extends TestCase
{
  public function testOptionsRequestReturnsOkAndHasHeaders()
  {
    $response = $this->json('OPTIONS', '/');

    $response
      ->seeStatusCode(200)
      ->seeHeader(
          'Access-Control-Allow-Headers',
          'authorization, content-type'
      )
      ->seeHeader(
          'Access-Control-Allow-Methods',
          'GET, POST, PUT, DELETE'
      )
      ->seeHeader(
          'Access-Control-Allow-Origin',
          '*'
      );
  }
}
