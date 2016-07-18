<?php

require_once('resources.php');

class UdoitTest extends PHPUnit_Framework_TestCase
{
    protected $data;

    public function setUp () {
        $this->data = [
            'api_key'       => '',
            'base_uri'      => '',
            'content_types' => ['pages'],
            'course_id'     => '654321',
            'test'          => true
        ];
    }

    public function checkOutputBuffer() {
        $buffer     = ob_get_clean();
        $this->assertEquals('', $buffer);
    }

    public function testBuildReport() {

        $test       = '';

        ob_start();
        $temp       = new Udoit($this->data);

        $out = $temp->buildReport();

        $results    = $temp->bad_content['pages']['items'];

        $this->assertEquals($test, $out);

        $this->assertCount(14, count($results));

        $this->checkOutputBuffer();
    }

    public function testParseLinks() {
        $parse      = '<https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100>; rel="current",<https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100>; rel="first",<https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100>; rel="last"';
        $pretty     = [
                "current"   => "https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100",
                "first"     => "https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100",
                "last"      => "https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100"
            ];

        ob_start();
        $temp       = new Udoit($this->data);
        $temp->parseLinks($links);

        $this->assertTrue(is_array($output) && array_diff($pretty, $output) === array_diff($output, $pretty));
        $this->checkOutputBuffer();
    }

    public function tearDown () {
        unset($data);
    }

}