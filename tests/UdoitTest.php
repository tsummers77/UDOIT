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
        // $test = '';
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
            foreach( $page->error as $error_page ) {
                switch ( $error_page['id'] ) {
                    case 'headershavetext':
                        $error = $error_page->error[0]->html;
                        $expected = '<h1></h1>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'amustcontaintext':
                        $error = $error_page->error[0]->html;
                        $expected = '<a href="https://www.google.com/&amp;c=1" target="_blank"></a>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'asuspiciouslinktext':
                        $error = $error_page->error[0]->html;
                        $expected = '<a href="http://example.com/document.pdf">Click Here</a>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'alinktextdoesnotbeginwithredundantword':
                        $error = $error_page->error[0]->html;
                        $expected = '<a href="https://www.google.com/">link to site</a>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'csstexthascontrast':
                        $error = $error_page->error[0]->html;
                        $expected = '<p style="color: #ffff00;">Colored “Text”</p>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'csstextstyleemphasize':
                        $error = $error_page->error[0]->html;
                        $expected = '<p style="color: #00000f;">Colored “Text”</p>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'imghasalt':
                        $error = $error_page->error[0]->html;
                        $expected = '<img src="https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_272x92dp.png" alt="">';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'imgaltisdifferent':
                        $error = $error_page->error[0]->html;
                        $expected = '<img src="https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png" alt="googlelogo_color_272x92dp.png"></p>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'tabledatashouldhaveth':
                        $error = $error_page->error[0]->html;
                        $expected = '<table border="1"><tbody><tr><td>Header 1</td>
<td>Header 2</td>
</tr><tr><td>Placeholder 1</td>
<td>Placeholder 2</td>
</tr></tbody></table>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'tablethshouldhavescope':
                        $error = $error_page->error[0]->html;
                        $expected = '<th>Header 1</th>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'pnotusedasheader':
                        $error = $error_page->error[0]->html;
                        $expected = '<p><strong>Bolded Paragraph Text</strong></p>';
                        $this->assertEquals( $expected, $error);
                        break;

                    case 'videosembeddedorlinkedneedcaptions':
                        $error = $error_page->error[0]->html;
                        $expected = '<a id="" class="" title="" href="https://www.youtube.com/watch?v=oJ9VbNtPhIk" target="">Video With Captions</a>';
                        $this->assertEquals( $expected, $error);
                        break;
                }
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