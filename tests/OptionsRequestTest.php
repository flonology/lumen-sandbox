<?php
class OptionsRequestTest extends TestCase
{
  public function testOptionsRequestReturnsOk()
  {
    $response = $this->call('OPTIONS', '/');
    $this->assertEquals(200, $response->status());
  }
}
