<?php

require_once('resources.php');

class UdoitTest extends PHPUnit_Framework_TestCase
{
    protected $data;

    public function setUp () {
        $this->data = [
            'api_key'       => '',
            'base_uri'      => '',
            'content_types' => ['announcements', 'assignments', 'discussions', 'files', 'pages', 'syllabus', 'modules'],
            'course_id'     => '654321',
            'test'          => true
        ];
    }

    public function checkOutputBuffer() {
        $buffer         = ob_get_clean();
        $this->assertEquals('', $buffer);
    }

    public function testParseLinks() {
        $error_html     = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="">';
        $new_content    = 'test';
        $expected       = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="test">';

        ob_start();
        $temp           = new Ufixit($this->data);
        $output         = $temp->fixAltText($error_html, $new_content);

        $this->assertEquals($expected, $output);
        $this->checkOutputBuffer();
    }

    public function testBuildReport() {
        $error_html     = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="">';
        $new_content    = 'test';
        $expected       = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="test">';

        ob_start();
        $temp           = new Ufixit($this->data);
        $output         = $temp->fixAltText($error_html, $new_content);

        $this->assertEquals($expected, $output);
        $this->checkOutputBuffer();
    }

    public function testBuildReport() {
        $error_html     = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="">';
        $new_content    = 'test';
        $expected       = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="test">';

        ob_start();
        $temp           = new Ufixit($this->data);
        $output         = $temp->fixAltText($error_html, $new_content);

        $this->assertEquals($expected, $output);
        $this->checkOutputBuffer();
    }

    public function testBuildReport() {
        $error_html     = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="">';
        $new_content    = 'test';
        $expected       = '<img src="https://webcourses.ucf.edu/courses/1234567/image.jpg" alt="test">';

        ob_start();
        $temp           = new Ufixit($this->data);
        $output         = $temp->fixAltText($error_html, $new_content);

        $this->assertEquals($expected, $output);
        $this->checkOutputBuffer();
    }

    public function tearDown () {
        unset($data);
    }

}