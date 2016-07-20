<?php

require_once(__DIR__.'/../config/settings.php');

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
        $test = '';
        $errors = [];

        ob_start();
        $temp       = new Udoit($this->data);
        $temp->buildReport();

        $results    = $temp->bad_content['pages']['items'];

        $this->checkOutputBuffer();

        $this->assertEquals($test, print_r($results, true));

        $this->assertTrue(is_array($results));
        $this->assertTrue(count($results) === 10);

        foreach( $results as $page ) {
            foreach( $page['error'] as $error ) {
                array_push( $errors, $error );
            }
        }


    }

    public function testParseLinks() {
        $links      = '<https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100>; rel="current",<https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100>; rel="first",<https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100>; rel="last"';
        $pretty     = [
                "current"   => "https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100",
                "first"     => "https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100",
                "last"      => "https://resources.instructure.com/api/v1/courses/1200137/files?page=1&per_page=100"
            ];

        ob_start();
        $temp       = new Udoit($this->data);
        $output     = $temp->parseLinks($links);

        $this->assertTrue(is_array($output) && array_diff($pretty, $output) === array_diff($output, $pretty));
        $this->checkOutputBuffer();
    }

    public function tearDown () {
        unset($data);
    }

}