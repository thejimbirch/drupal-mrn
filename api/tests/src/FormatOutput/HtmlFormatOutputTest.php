<?php

namespace App\Tests\FormatOutput;

use App\Changelog;
use App\FormatOutput\HtmlFormatOutput;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\FormatOutput\HtmlFormatOutput
 */
class HtmlFormatOutputTest extends TestCase
{

    /**
     * @covers ::format
     */
    public function testFormat()
    {
        $client = new Client();
        $fixture = json_decode(file_get_contents(__DIR__.'/../../fixtures/views_remote_data.json'));
        $changelog = new Changelog(
          $client,
          'views_remote_data',
          $fixture->commits,
          '1.0.1',
          '1.0.2'
        );
        $sut = new HtmlFormatOutput();
        $expected = <<<HTML
<p><em>Add a summary here</em></p>
<h3>Contributors (2)</h3>
<p><a href="https://www.drupal.org/u/lal_">Lal_</a>, <a href="https://www.drupal.org/u/mrinalini9">mrinalini9</a></p>
<h3>Changelog</h3>
<p><strong>Issues:</strong> 1 issues resolved.</p>
<p>Changes since <a href="https://www.drupal.org/project/views_remote_data/releases/1.0.1">1.0.1</a>:</p>
<h4>Task</h4>
<ul>
  <li>#3294296 by mrinalini9, Lal_: Drupal 10 readiness for the module</li>
</ul>
HTML;

        self::assertEquals(
          $expected,
          $sut->format($changelog)
        );
    }

}
